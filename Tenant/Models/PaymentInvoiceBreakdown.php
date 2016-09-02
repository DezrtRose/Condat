<?php
namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class PaymentInvoiceBreakdown extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payment_invoice_breakdowns';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'payment_invoice_breakdown_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['invoice_id', 'payment_id'];

    /**
     * Disable default timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

    /*
     * Assign Payment to Invoice
     */
    public function assign(array $request, $payment_id)
    {
        PaymentInvoiceBreakdown::create([
            'invoice_id' => $request['invoice_id'],
            'payment_id' => $payment_id
        ]);
        return true;
    }
}