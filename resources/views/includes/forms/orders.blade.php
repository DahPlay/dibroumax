<div class="modal-body">
    <div class="row d-flex align-items-center">
        <div class="form-group col-6">
            <label for="customer_asaas_id" class="col-form-label">Customer Asaas ID:</label>
            <div class="input-group">
                <input type="text" id="customer_asaas_id" class="form-control" name="customer_asaas_id"
                    placeholder="Customer Asaas ID" value="{{ $order->customer_asaas_id }}" disabled>
            </div>
        </div>

        <div class="form-group col-6">
            <label for="subscription_asaas_id" class="col-form-label">Subscription Asaas ID:</label>
            <div class="input-group">
                <input type="text" id="subscription_asaas_id" class="form-control" name="subscription_asaas_id"
                    placeholder="Subscription Asaas ID" value="{{ $order->subscription_asaas_id }}" disabled>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-6">
            <label for="value" class="col-form-label">Preço:</label>
            <div class="input-group">
                <input type="text" id="value" class="form-control" name="value" placeholder="Preço"
                    value="{{ number_format($order->value, 2, ',', '.') }}" disabled>
            </div>
        </div>

        <div class="form-group col-6">
            <label for="cycle" class="col-form-label">Ciclo de pagamento:</label>
            <div class="input-group">
                <input type="text" id="cycle" class="form-control" name="cycle" placeholder="Ciclo"
                    value="{{ $order->cycle }}" disabled>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-4">
            <label for="billing_type" class="col-form-label">Tipo de pagamento:</label>
            <div class="input-group">
                <input type="text" id="billing_type" class="form-control" name="billing_type"
                    placeholder="Billing Type" value="{{ $order->billing_type }}" disabled>
            </div>
        </div>

        <div class="form-group col-4">
            <label for="next_due_date" class="col-form-label">Grátis até:</label>
            <div class="input-group">
                <input type="date" id="next_due_date" class="form-control" name="next_due_date"
                    placeholder="Next Due Date" value="{{ $order->next_due_date }}" disabled>
            </div>
        </div>

        <div class="form-group col-4">
            <label for="status" class="col-form-label">Status:</label>
            <div class="input-group">
                <input type="text" id="status" class="form-control" name="status" placeholder="Status"
                    value="{{ $order->status }}" disabled>
            </div>
        </div>
    </div>

    <div class="row">
        <label for="description" class="col-form-label">Descrição:</label>
        <div class="form-group col-12">
            <div class="input-group">
                <textarea id="description" class="form-control" name="description" rows="3" placeholder="Description" disabled>{{ $order->description }}</textarea>
            </div>
        </div>
    </div>
</div>
