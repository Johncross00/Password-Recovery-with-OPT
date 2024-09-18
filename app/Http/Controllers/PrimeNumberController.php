<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimeNumberController extends Controller
{
    public function getPrimeNumbers(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|min:2',
        ]);

        $number = $request->input('number');

        $primeNumbers = $this->findPrimeNumbersBefore($number);

        return response()->json([
            'success' => true,
            'prime_numbers' => $primeNumbers,
        ], 200);
    }

    private function findPrimeNumbersBefore($n)
    {
        $primes = [];
        for ($i = 2; $i < $n; $i++) {
            if ($this->isPrime($i)) {
                $primes[] = $i;
            }
        }
        return $primes;
    }

    private function isPrime($num)
    {
        if ($num < 2) {
            return false;
        }
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }
        return true;
    }
}
