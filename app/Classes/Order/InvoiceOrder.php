<?php
namespace App\Classes\Order;

use App\Models\Order;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Classes\Order\Visitors\OrderProductCreator;
use App\Classes\Order\Visitors\OrderTotalCalculate;
use App\Classes\Order\Visitors\OrderCustomerCreator;
use App\Helper\OrderInvoiceGenerate;

class InvoiceOrder {
  public Request $request;

  public Array $items;

  public Order $order;

  public $bankAccount;

  public $checkoutTotalPrice = 0;

  public $customer;

  /**
   * constructor class
   *
   * @param Request $request
   */
  public function __construct(Request $request) {
    $this->request = $request;
  }

  public function setCartItems($items) {
    $this->items = $items;
    return $this;
  }

  public function setCustomer($customer) {
    $this->customer = $customer;
    return $this;
  }

  public function create() {
    $this->_getBankAccount();
    $this->_getOrder();

    (new OrderProductCreator)->run($this);
    (new OrderCustomerCreator)->run($this);
    (new OrderTotalCalculate)->run($this);
    $this->order->save();

    $this->_customerCartDelete();
  }

  public function _customerCartDelete() {
    if ($this->request->cart_item_ids && count($this->request->cart_item_ids) > 0 ) {
      $this->customer->cartProducts()->whereIn('id', $this->request->cart_item_ids)->delete();
    }
    $this->customer->cartProducts()->delete();
  }

  private function _getOrder() {
    $order                  = new Order();
    $order->order_number    = (new OrderInvoiceGenerate())->orderNumber();
    $order->customer_id     = $this->customer->id;
    $order->bank_account_id = !empty($this->bankAccount->id) ? $this->bankAccount->id : null;
    $order->payment_type    = !empty($this->bankAccount->name) ? $this->bankAccount->name : 'Cash On Delivery';
    $order->paid_at         = now();

    if ($this->request->hasFile('screenshot')) {
      $order->payment_screenshot = $this->request->file('screenshot')->store('orders');
    }

    $order->save();
    $this->order = $order;
  }

  private function _getBankAccount() {
    // bank Account Check
    $bankAccount = BankAccount::find($this->request->bank_account_id);
    if (!$bankAccount) {
      return $this->bankAccount = null;
    }

    return $this->bankAccount = $bankAccount;
  }
}