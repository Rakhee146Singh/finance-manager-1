<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenceRequest;

class ExpenceRequestController extends Controller
{
    /**
     * API of List Expence
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $expence
     */
    public function list(Request $request)
    {
        //validation
        $this->validate($request, [
            'per_page'   => 'required|numeric',
            'page'       => 'required|numeric',
            'sort_field' => 'nullable',
            'sort_order' => 'nullable|in:asc,desc',
            'date'       => 'nullable',
        ]);
        $expence = ExpenceRequest::query();
        //sorting
        if ($request->sort_field && $request->sort_order) {
            $expence =  $expence->orderBy($request->sort_field, $request->sort_order);
        } else {
            $expence =  $expence->orderBy('id', 'DESC');
        }
        //searching
        if (isset($request->date)) {
            $expence->where("date", "LIKE", "%{$request->date}%");
        }
        //pagination
        $per_page = $request->per_page;
        $page    = $request->page;
        $expence  = $expence->skip($per_page * ($page - 1))->take($per_page);
        return response()->json([
            "success" => true,
            "message" => "Expense List.",
            'data'    => $expence->get()
        ]);
    }
    /**
     * API of Create Expence
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $expence
     */
    public function create(Request $request)
    {
        //validation code
        $this->validate($request, [
            'amount'                             => 'required|string',
            'date'                               => 'required|date',
            'attachment'                         => 'nullable|mimes:jpg,bmp,png,pdf',
            'is_approved'                        => 'nullable|boolean',
            'approval_status'                    => 'nullable|in:Paid,Unpaid,Prepaid',
            'description'                        => 'nullable|string',
            'is_active'                          => 'nullable|boolean',
            'financial_year_id'                  => 'required|string|exists:financial_years,id',
            'users.*'                            => 'required|array',
            'users.*user_id'                     => 'required|string|exists:users,id',
        ]);
        $expence = ExpenceRequest::create($request->only('financial_year_id', 'date', 'amount', 'attachment', 'description', 'is_approved', 'approval_status'));
        $expence->users()->sync($request->users);
        return response()->json([
            "success" => true,
            "message" => "Expence created successfully.",
            'data'    => $expence->load('users')
        ]);
    }
    /**
     * API of get perticuler Expence details
     *
     * @param  $id
     * @return $expence
     */
    public function view($id)
    {
        $expence = ExpenceRequest::with('users')->findOrFail($id);
        return response()->json([
            "success" => true,
            "message" => "Expence retrieved successfully.",
            "data"    => $expence
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
            'is_approved'                        => 'required|boolean',
            'approval_status'                    => 'required|in:Paid,Unpaid,Prepaid',
            'approval_by'                        => 'required|string|exists:users,id',

        ]);
        $compoff = ExpenceRequest::findOrFail($id);
        $compoff->update($request->only('is_approved', 'approval_status', 'approval_by'));
        return response()->json([
            "success" => true,
            "message" => "Expence Updated Successfully",
        ]);
    }
    /**
     * API of Update Expence
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function update(Request $request, $id)
    {
        //validation code
        $this->validate($request, [
            'amount'                             => 'required|string',
            'date'                               => 'required|date',
            'attachment'                         => 'nullable|mimes:jpg,bmp,png,pdf',
            'is_approved'                        => 'nullable|boolean',
            'approval_status'                    => 'nullable|in:Paid,Unpaid,Prepaid',
            'description'                        => 'nullable|string',
            'is_active'                          => 'nullable|boolean',
            'users.*'                            => 'required|array',
            'users.*user_id'                     => 'required|string|exists:users,id',
            'financial_year_id'                  => 'required|string|exists:financial_years,id',
            'approval_by'                        => 'nullable|string|exists:users,id',
        ]);
        $expence = ExpenceRequest::findOrFail($id);
        $expence->update($request->only('financial_year_id', 'date', 'amount', 'attachment', 'description', 'is_approved', 'approval_status', 'approval_by'));
        $expence->users()->sync($request->users);
        return response()->json([
            "success" => true,
            "message" => "Expence Updated successfully.",
        ]);
    }
    /**
     * API of Delete Expense
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function delete($id)
    {
        $expence = ExpenceRequest::findOrFail($id);;
        if ($expence->users()->count() > 0) {
            $expence->users()->detach();
        }
        $expence->delete();
        return response()->json([
            "success" => true,
            "message" => "Expence deleted successfully.",
        ]);
    }
}
