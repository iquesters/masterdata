<?php

namespace Iquesters\Masterdata\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Constants\EntityStatus;
use App\Models\MasterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class MasterDataController extends Controller
{
    // Display a listing of master data
    public function index()
    {
        try {
            Log::info('Fetching all master data');
            $user = Auth::user();

            $isSuperAdmin = false;

            if (method_exists($user, 'hasRole')) {
                $isSuperAdmin = $user->hasRole('super-admin');
            } elseif (isset($user->is_admin) && $user->is_admin) {
                $isSuperAdmin = true;
            }

            $statuses = $isSuperAdmin
                ? null // null means show all statuses
                : [EntityStatus::ACTIVE, EntityStatus::INACTIVE];
            $masterData = MasterData::with('metas')
                ->when($statuses, function ($query, $statuses) {
                    return $query->whereIn('status', $statuses);
                })
                ->get();
            Log::debug('Master data fetched successfully', [
                'count' => $masterData->count(),
                'is_super_admin' => $isSuperAdmin
            ]);
            return view('master_data.index', [
                'masterData' => $masterData,
                'selectedNode' => null,
                'parentNode' => null,
                'childNodes' => null,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching master data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'An error occurred while fetching master data.');
        }
    }
    public function show(MasterData $master_datum)
    {
        try {
            $masterData = MasterData::with('metas')->get();
            $selectedNode = $master_datum;
            $parentNode = $selectedNode->parent;
            $childNodes = $selectedNode->children;

            return view('master_data.index', [
                'masterData' => $masterData,
                'selectedNode' => $selectedNode,
                'parentNode' => $parentNode,
                'childNodes' => $childNodes
            ]);
        } catch (Exception $e) {
            Log::error('Error showing master data details', ['error' => $e->getMessage()]);
            return redirect()->route('master-data.index')->with('error', 'Error loading master data details');
        }
    }

    // Store newly created master data
    public function store(Request $request)
    {
        try {
            Log::info('Starting master data creation process');
            $user = Auth::user();

            $request->validate([
                'key' => 'required|string|max:255',
                'value' => 'nullable|string',
                'parent_id' => 'nullable|integer',
                'meta_keys' => 'nullable|array',
                'meta_values' => 'nullable|array',
            ]);

            // Set parent_id to 0 if not provided
            $parentId = $request->parent_id ?? 0;

            // Create master data
            $masterData = MasterData::create([
                'key' => $request->key,
                'value' => $request->value,
                'parent_id' => $parentId,
                'status' => 'active',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            Log::info('Master data created successfully', ['id' => $masterData->id]);

            // Add meta data
            if ($request->meta_keys && $request->meta_values) {
                Log::debug('Adding meta data to master data', ['meta_keys' => $request->meta_keys, 'meta_values' => $request->meta_values]);
                foreach ($request->meta_keys as $index => $key) {
                    if (!empty($key)) {
                        Log::debug('Setting meta value', ['key' => $key, 'value' => $request->meta_values[$index]]);
                        $masterData->setMetaValue($key, $request->meta_values[$index], $user->id);
                    }
                }
            }

            Log::info('Master data creation process completed successfully');
            return redirect()->back()->with('success', 'Master data created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating master data', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while creating master data.');
        }
    }

    // Update master data
    public function update(Request $request, MasterData $master_datum)
    {
        try {
            Log::info('Starting master data update process', ['id' => $master_datum->id]);
            $user = Auth::user();

            $request->validate([
                'key' => 'required|string|max:255',
                'value' => 'nullable|string',
                'parent_id' => 'nullable|integer',
                'meta_keys' => 'nullable|array',
                'meta_values' => 'nullable|array',
            ]);

            // Set parent_id to 0 if not provided
            $parentId = $request->parent_id ?? 0;
            $master_data = MasterData::find($master_datum->id);
            // Update master data
            $master_data->update([
                'key' => $request->key,
                'value' => $request->value,
                'parent_id' => $parentId,
                'updated_by' => $user->id,
            ]);

            Log::info('Master data updated successfully', ['id' => $master_data->id]);

            // Delete existing metas and add new ones
            // $master_data->metas()->delete();
            Log::debug('Existing meta data deleted', ['id' => $master_data->id]);

            if ($request->meta_keys && $request->meta_values) {
                Log::debug('Adding new meta data to master data', ['meta_keys' => $request->meta_keys, 'meta_values' => $request->meta_values]);
                foreach ($request->meta_keys as $index => $key) {
                    if (!empty($key)) {
                        Log::debug('Setting meta value', ['key' => $key, 'value' => $request->meta_values[$index]]);
                        $master_data->setMetaValue($key, $request->meta_values[$index], $user->id);
                    }
                }
            }

            Log::info('Master data update process completed successfully', ['id' => $master_data->id]);
            return redirect()->back()->with('success', 'Master data updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating master data', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while updating master data.');
        }
    }

    // Delete master data
    public function destroy(Request $request, MasterData $master_datum)
    {
        try {
            Log::info('Starting master data deletion process', [
                'id' => $master_datum->id,
                'master_datum' => $master_datum->toArray()
            ]);

            // Get fresh instance to ensure events trigger
            $masterData = MasterData::findOrFail($master_datum->id);

            $masterData->metas()->delete();

            // Soft delete the master record
            $masterData->update([
                'status' => EntityStatus::DELETED,
                'updated_by' => Auth::id(),
            ]);

            Log::info('Master data deleted successfully', ['id' => $masterData->id]);

            return redirect()
                ->back()
                ->with('success', 'Master data deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting master data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting master data.');
        }
    }
}