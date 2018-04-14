<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
class HomeController extends Controller
{
    public function gotoIndex()
    {
        return view('users.index');
    }

    public function getHighTides() {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.tideschart.com/Philippines/Central-Luzon/Province-of-Bulacan/Hagonoy/');
        $crawler->filter('.col_two_third .bottommargin-sm > p')->each(function ($node) {
            print $node->text()."\n";
        });
    }
}
