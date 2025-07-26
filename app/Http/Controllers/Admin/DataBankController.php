<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DataBankController extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Bank::paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Bank",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-bank", $data);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            "bank" => ["required", "max:255", "unique:banks"],
            "type" => ["required"],
        ]);

        // If validation fails, redirect back with error messages
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Retrieve the bank data from the validated request
        $bankData = $validator->validated();
        $bankData["nama_bank"] = $request->input("nama_bank");
        $bank = Bank::create($bankData);

        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function update(Request $request)
    {
        // Retrieve the bank data from the request
        $bankData = $request->only(["id", "bank", "nama_bank", "type"]);

        // Find the bank by ID
        $bank = Bank::find($bankData["id"]);
        $bank->update($bankData);

        // Redirect or return a response
        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function Ajax(Request $request)
    {
        $DataTabel = Bank::paginate(10);
        $partialView = view(
            "admin.partial.data-bank",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function get_data_bank(Request $request)
    {
        $id = $request->input("id");

        $query = Bank::query();
        $bank = $query->where("id", $id)->first();

        // Return the partial view as JSON response
        return response()->json(["bank" => $bank]);
    }
}
