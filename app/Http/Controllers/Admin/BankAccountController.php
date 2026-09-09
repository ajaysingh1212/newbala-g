<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(10);
        return view('admin.bank_accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_holder_name' => 'required|string',
            'account_number' => 'required|string|unique:bank_accounts',
            'ifsc_code' => 'required|string',
            'bank_name' => 'required|string',
            'upi_id' => 'nullable|string|unique:bank_accounts',
            'upi_scanner' => 'nullable|image|max:2048',
            'print_on_ticket' => 'boolean',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('upi_scanner')) {
            $data['upi_scanner'] = $request->file('upi_scanner')->store('bank_accounts', 'public');
        }

        BankAccount::create($data);

        return redirect()->route('admin.bank_accounts.index')->with('success', 'Bank Account created successfully');
    }

    public function edit($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        return view('admin.bank_accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_holder_name' => 'required|string',
            'account_number' => 'required|string|unique:bank_accounts,account_number,' . $id,
            'ifsc_code' => 'required|string',
            'bank_name' => 'required|string',
            'upi_id' => 'nullable|string|unique:bank_accounts,upi_id,' . $id,
            'upi_scanner' => 'nullable|image|max:2048',
            'print_on_ticket' => 'boolean',
            'status' => 'required|in:active,inactive'
        ]);

        $bankAccount = BankAccount::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('upi_scanner')) {
            $data['upi_scanner'] = $request->file('upi_scanner')->store('bank_accounts', 'public');
        }

        $bankAccount->update($data);

        return redirect()->route('admin.bank_accounts.index')->with('success', 'Bank Account updated successfully');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $bankAccount->delete();

        return redirect()->route('admin.bank_accounts.index')->with('success', 'Bank Account deleted successfully');
    }
}
