import re

def clean_and_comment_payment_controller():
    filepath = r'D:\xampp\htdocs\HMS\app\Http\Controllers\PaymentController.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    content_norm = content.replace('\r\n', '\n')
    
    # 1. Clean excessive newlines (3+ to 2)
    content_norm = re.sub(r'\n{3,}', '\n\n', content_norm)
    
    # 2. Remove duplicate return block in store()
    duplicate_return = """        return redirect()->route('payments.index')

            ->with('success', 'Payment recorded successfully.');"""
            
    # We want to replace it only if there is a second one. Let's do it safely.
    # In the normalized cleaned content, the store method looks like:
    #         $payment = Payment::create($validated);
    #
    #         // Auto-update invoice status to paid if payment is completed
    #         if ($payment->status === 'completed' && $payment->invoice) {
    #             $payment->invoice->update(['status' => 'paid']);
    #         }
    #
    #         return redirect()->route('payments.index')
    #             ->with('success', 'Payment recorded successfully.');
    #
    #         return redirect()->route('payments.index')
    #             ->with('success', 'Payment recorded successfully.');
    
    # Let's find the store method and refine the comments & logic
    old_store_tail = """        $payment = Payment::create($validated);

        // Auto-update invoice status to paid if payment is completed
        if ($payment->status === 'completed' && $payment->invoice) {
            $payment->invoice->update(['status' => 'paid']);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');"""
            
    new_store_tail = """        $payment = Payment::create($validated);

        // Auto-update the linked invoice status to 'paid' when a payment is marked as 'completed'
        if ($payment->status === 'completed' && $payment->invoice) {
            $payment->invoice->update(['status' => 'paid']);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');"""
            
    if old_store_tail.replace('\r\n', '\n') in content_norm:
        content_norm = content_norm.replace(old_store_tail.replace('\r\n', '\n'), new_store_tail)
        print("Updated store tail and comments in PaymentController.php")
        
    # Let's also add clear comments to the status default assignment in store()
    old_status_assignment = """        // All payments are marked as completed by default
        $validated['status'] = 'completed';
        if ($validated['payment_method'] === 'cash') {
            $validated['transaction_id'] = null; // No transaction ID for cash
        }"""
        
    new_status_assignment = """        // Electronic / Bank / Card payments default to 'completed' status immediately.
        // Account division manages any subsequent settlement issues offline/asynchronously.
        $validated['status'] = 'completed';
        if ($validated['payment_method'] === 'cash') {
            $validated['transaction_id'] = null; // No transaction ID for cash
        }"""
        
    if old_status_assignment.replace('\r\n', '\n') in content_norm:
        content_norm = content_norm.replace(old_status_assignment.replace('\r\n', '\n'), new_status_assignment)
        print("Updated status default comments in PaymentController.php")
        
    # Let's add comments to update() invoice trigger as well
    old_update_tail = """        // Auto-update invoice status to paid if payment is completed
        if ($payment->status === 'completed' && $payment->invoice) {
            $payment->invoice->update(['status' => 'paid']);
        }"""
        
    new_update_tail = """        // Auto-update the linked invoice status to 'paid' if the payment is updated to 'completed'
        if ($payment->status === 'completed' && $payment->invoice) {
            $payment->invoice->update(['status' => 'paid']);
        }"""
        
    if old_update_tail.replace('\r\n', '\n') in content_norm:
        content_norm = content_norm.replace(old_update_tail.replace('\r\n', '\n'), new_update_tail)
        print("Updated update tail comments in PaymentController.php")
        
    with open(filepath, 'w', encoding='utf-8', newline='\r\n') as f:
        f.write(content_norm.replace('\n', '\r\n'))
    print("Successfully completed PaymentController.php comments update")

def clean_and_comment_invoice_controller():
    filepath = r'D:\xampp\htdocs\HMS\app\Http\Controllers\InvoiceController.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    content_norm = content.replace('\r\n', '\n')
    
    # 1. Clean excessive newlines (3+ to 2)
    content_norm = re.sub(r'\n{3,}', '\n\n', content_norm)
    
    # 2. Add comments to instant payment block
    old_instant = """            // Auto-update invoice status to paid
            $invoice->update(['status' => 'paid']);"""
            
    new_instant = """            // Automatically mark the invoice status as 'paid' since an instant payment has been registered
            $invoice->update(['status' => 'paid']);"""
            
    if old_instant in content_norm:
        content_norm = content_norm.replace(old_instant, new_instant)
        print("Updated instant payment comments in InvoiceController.php")
        
    with open(filepath, 'w', encoding='utf-8', newline='\r\n') as f:
        f.write(content_norm.replace('\n', '\r\n'))
    print("Successfully completed InvoiceController.php comments update")

def clean_and_comment_routes():
    filepath = r'D:\xampp\htdocs\HMS\routes\web.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    content_norm = content.replace('\r\n', '\n')
    
    # 1. Clean excessive newlines (3+ to 2)
    content_norm = re.sub(r'\n{3,}', '\n\n', content_norm)
    
    # 2. Add comment for the reordered invoice routes
    old_invoices_reordered = """    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create')->middleware('role:admin,manager,staff');
    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store')->middleware('role:admin,manager,staff');"""
    
    new_invoices_reordered = """    // Explicitly register specific routes before resource routes to prevent routing conflicts
    // e.g. invoices.create should not be matched by invoices.{invoice} wildcard
    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create')->middleware('role:admin,manager,staff');
    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store')->middleware('role:admin,manager,staff');"""
    
    if old_invoices_reordered in content_norm:
        content_norm = content_norm.replace(old_invoices_reordered, new_invoices_reordered)
        print("Added routing precedence comments in web.php")
        
    with open(filepath, 'w', encoding='utf-8', newline='\r\n') as f:
        f.write(content_norm.replace('\n', '\r\n'))
    print("Successfully completed web.php comments update")

clean_and_comment_payment_controller()
clean_and_comment_invoice_controller()
clean_and_comment_routes()
