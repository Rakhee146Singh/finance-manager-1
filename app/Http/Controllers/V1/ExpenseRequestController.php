<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenseRequest;

class ExpenseRequestController extends Controller
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
            'page'          => 'nullable|integer',
            'perPage'       => 'nullable|integer',
            'search'        => 'nullable',
            'sort_field'    => 'nullable',
            'sort_order'    => 'nullable|in:asc,desc',
            'date'          => 'nullable',
        ]);

        $query = ExpenseRequest::query();

        if ($request->search) {
            $query = $query->where('description', 'like', "%$request->search%");
        }

        if ($request->date) {
            $query = $query->whereDate('date', $request->date);
        }

        if ($request->sort_field || $request->sort_order) {
            $query = $query->orderBy($request->sort_field, $request->sort_order);
        }

        /* Pagination */
        $count = $query->count();
        if ($request->page && $request->perPage) {
            $page = $request->page;
            $perPage = $request->perPage;
            $query = $query->skip($perPage * ($page - 1))->take($perPage);
        }

        /* Get records */
        $expence = $query->get();

        $data = [
            'count' => $count,
            'data'  => $expence
        ];

        return ok('Expence list', $data);
    }

    /**
     * API of Create Expence
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $expence
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'financial_year_id'     => 'required|string|exists:financial_years,id',
            'date'                  => 'required|date',
            'amount'                => 'required|numeric',
            'attachment'            => 'nullable|mimes:jpg,bmp,png,pdf',
            'description'           => 'nullable|string|max:551',
            'is_active'             => 'nullable|boolean'
        ]);

        $expence = ExpenseRequest::create($request->only('financial_year_id', 'date', 'amount', 'attachment', 'description'));
        return ok('Expence created successfully', $expence);
    }

    /**
     * API of Update Expence
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'financial_year_id'     => 'required|string|exists:financial_years,id',
            'date'                  => 'required|date',
            'amount'                => 'required|numeric',
            'attachment'            => 'nullable|mimes:jpg,bmp,png,pdf',
            'description'           => 'nullable|string|max:551',
            'is_active'             => 'nullable|boolean'
        ]);
        $expence = ExpenseRequest::findOrFail($id);
        $expence->update($request->only('financial_year_id', 'date', 'amount', 'attachment', 'description'));
        return ok('Expence updated successfully', $expence);
    }

    /**
     * API of get perticuler Expence details
     *
     * @param  $id
     * @return $expence
     */
    public function get($id)
    {
        $expence = ExpenseRequest::findOrFail($id);

        return ok('Expence retrieved successfully', $expence);
    }

    /**
     * API of Delete Expense
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function delete($id)
    {
        $expence = ExpenseRequest::findOrFail($id);
        $expence->delete();

        return ok('Expence deleted successfully');
    }

    /**
     * API of Approval
     *
     * @param  $id
     */
    public function approval($id, Request $request)
    {
        $this->validate($request, [
            'is_approved'       => 'required|boolean',
            'approval_status'   => 'required|in:P,U,PP',
            'approval_by'       => 'required|string|exists:users,id',
        ]);

        $compoff = ExpenseRequest::findOrFail($id);
        $compoff->update($request->only('is_approved', 'approval_status', 'approval_by'));

        return ok('Expence updated Successfully');
    }
}
