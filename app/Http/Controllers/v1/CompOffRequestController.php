<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\CompOffRequest;
use App\Http\Controllers\Controller;

class CompOffRequestController extends Controller
{
    /**
     * API of List CompOff
     *
     * @param  \Illuminate\Http\Request  $request
     *@return $compoff
     */
    public function list(Request $request)
    {
        $this->validate($request, [
            'page'          => 'nullable|integer',
            'perPage'       => 'nullable|integer',
            'search'        => 'nullable',
            'sort_field'    => 'nullable',
            'sort_order'    => 'nullable|in:asc,desc',
            'date'          => 'nullable|date',
        ]);

        $query = CompOffRequest::query();

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
        $compoff = $query->get();

        $data = [
            'count' => $count,
            'data'  => $compoff
        ];

        return ok('Compoff list', $data);
    }

    /**
     * API of Create Compoff
     *
     *@param  \Illuminate\Http\Request  $request
     *@return $compoff
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'financial_year_id'     => 'required|string|exists:financial_years,id',
            'user_id'               => 'required|string|exists:users,id',
            'date'                  => 'required|date',
            'description'           => 'nullable|string|max:551',
        ]);

        $compoff = CompOffRequest::create($request->only('financial_year_id', 'user_id', 'date', 'description'));

        return ok('Compoff created successfully!', $compoff);
    }

    /**
     * API of Update Compoff
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'financial_year_id'     => 'required|string|exists:financial_years,id',
            'user_id'               => 'required|string|exists:users,id',
            'date'                  => 'required|date',
            'description'           => 'nullable|string|max:551',
        ]);

        $compoff = CompOffRequest::findOrFail($id);
        $compoff->update($request->only('financial_year_id', 'user_id', 'date', 'description'));

        return ok('Compoff updated successfully!', $compoff);
    }

    /**
     * API of get perticuler Compoff details
     *
     * @param  $id
     * @return $compoff
     */
    public function get($id)
    {
        $compoff = CompOffRequest::with(['user'])->findOrFail($id);

        return ok('Comp off get successfully', $compoff);
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

        return ok('Compoff deleted successfully');
    }

    /**
     * API of Approval
     *
     * @param  $id
     */
    public function approval($id, Request $request)
    {
        $this->validate($request, [
            'is_fullday'            => 'nullable|boolean',
            'is_approved'           => 'nullable|boolean',
            'approval_status'       => 'nullable|in:A,R',
            'approval_by'           => 'nullable|string|exists:users,id',
        ]);

        $compoff = CompOffRequest::findOrFail($id);
        $compoff->update($request->only('approval_status', 'approval_by', 'is_fullday') + [
            'is_approved'   => $request->approval_status == 'A' ? true : false
        ]);

        return ok('Compoff updated successfully', $compoff);
    }
}
