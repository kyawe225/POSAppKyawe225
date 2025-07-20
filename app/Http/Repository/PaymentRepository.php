<?php
namespace App\Http\Repository;

interface IPaymentRepository extends ICrudRepository
{

}
// this should use payment and promocode usages.
class PaymentRepository implements IPaymentRepository
{
    public function create(array $request)
    {
    }
    private function calculateDiscount(){
        
    }
    public function update(int $id, array $request)
    {
    }
    public function delete(int $id)
    {
    }
    public function all()
    {
    }
    public function get(int $id)
    {
    }
}
?>