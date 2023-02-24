<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Models\CompOffRequest;
use App\Http\Controllers\Controller;


class CompOffRequestController extends Controller
{
    /**
     * API of List CompOff
     *
     *@param  \Illuminate\Http\Request  $request
     *@return $compoff
     */
    public function list(Request $request)
    {
        //validation
        $this->validate($request, [
            'per_page'    => 'required|numeric',
            'page'        => 'required|numeric',
            'sort_field'  => 'nullable',
            'sort_order'  => 'nullable|in:asc,desc',
            'date'        => 'nullable|date',
        ]);
        $compoff = CompOffRequest::query();
        //sorting
        if ($request->sort_field && $request->sort_order) {
            $compoff = $compoff->orderBy($request->sort_field, $request->sort_order);
        } else {
            $compoff = $compoff->orderBy('id', 'DESC');
        }
        //searching
        if (isset($request->date)) {
            $compoff->where("date", "LIKE", "%{$request->date}%");
        }
        //pagination
        $per_page = $request->per_page;
        $page    = $request->page;
        $compoff = $compoff->skip($per_page * ($page - 1))->take($per_page);
        return response()->json([
            "success" => true,
            "message" => "Compo Off List",
            "data"    => $compoff->get()
        ]);
    }
    /**
     * API of Create Compoff
     *
     *@param  \Illuminate\Http\Request  $request
     *@return $compoff
     */
    public function create(Request $request)
    {
        //validation code
        $this->validate($request, [
            'date'                               => 'required|date',
            'description'                        => 'nullable|string',
            'is_fullday'                         => 'nullable|boolean',
            'is_approved'                        => 'nullable|boolean',
            'approval_status'                    => 'nullable|in:Reject,Approve',
            'financial_year_id'                  => 'required|string|exists:financial_years,id',
            'user_id'                            => 'required|string|exists:users,id',


        ]);
        $compoff = CompOffRequest::create($request->only('financial_year_id', 'user_id', 'approval_by', 'date', 'description', 'is_fullday', 'is_approved', 'approval_status'));
        return response()->json([
            "success" => true,
            "message" => "Compoff Created successfully.",
            "data"    => $compoff
        ]);
    }
    /**
     * API of get perticuler Compoff details
     *
     * @param  $id
     * @return $compoff
     */
    public function view($id)
    {
        $compoff = CompOffRequest::findOrFail($id);
        return response()->json([
            "success" => true,
            "message" => "Comp off retrieved successfully.",
            "data"    => $compoff
        ]);
    }
    /**
     * API of Approval
     *
     * @param  $id
     */
    public function approval($id, Request $request)
    {
        $this->validate($request, [
            'is_fullday'                         => 'nullable|boolean',
            'is_approved'                        => 'nullable|boolean',
            'approval_status'                    => 'nullable|in:Reject,Approve',
            'approval_by'                        => 'nullable|string|exists:users,id',

        ]);
        $compoff = CompOffRequest::findOrFail($id);
        $compoff->update($request->only('is_approved', 'approval_status', 'approval_by', 'is_fullday'));
        return response()->json([
            "success" => true,
            "message" => "Compoff Updated Successfully",
        ]);
    }
    /**
     * API of Update Compoff
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function update(Request $request, $id)
    {
        //validation code
        $this->validate($request, [
            'date'                               => 'required|date',
            'description'                        => 'nullable|string',
            'is_fullday'                         => 'nullable|boolean',
            'is_approved'                        => 'nullable|boolean',
            'approval_status'                    => 'nullable|in:Reject,Approve',
            'financial_year_id'                  => 'required|string|exists:financial_years,id',
            'user_id'                            => 'required|string|exists:users,id',
            'approval_by'                        => 'nullable|string|exists:users,id',
        ]);
        $compoff = CompOffRequest::findOrFail($id);
        $compoff->update($request->only('financial_year_id', 'user_id', 'approval_by', 'date', 'description', 'is_fullday', 'is_approved', 'approval_status'));
        return response()->json([
            "success" => true,
            "message" => "Compoff Updated successfully.",
        ]);
    }
    /**
     * API of Delete Compoff
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function delete($id)
    {
        CompOffRequest::findOrFail($id)->delete();
        return response()->json([
            "success" => true,
            "message" => "Compoff deleted successfully.",
        ]);
    }
}
