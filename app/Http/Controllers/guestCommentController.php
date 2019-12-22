<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Inbox;
use App\Booking;
use App\Guest_comment as GC;
use Illuminate\Support\Facades\DB;


class guestCommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['postSaveGuestComment']]);;
    }

    public function postSaveGuestComment(Request $req){
    	if(!isset($req->user_id)) return responseSuccess(['success' => 'false', 'message' => 'please enter user ID!']);
    	$booking = Booking::where('user_id', $req->user_id)->where('status', 'selesai')->orderBy('id', 'desc')->first();

    	// if first booking
    	if(!isset($booking)){
    		$saveGC = MQ::insertGetId(array(
    					'booking_id' => $booking->id ,
    					'user_id' => $req->user_id ,
    					'gc_staff_pelayanan' => $req->gc_staff_pelayanan ,
    					'gc_suasana_spa' => $req->gc_suasana_spa ,
    					'gc_kebersihan_kenyamanan' => $req->gc_kebersihan_kenyamanan ,
    					'gc_teknik_perawatan' => $req->gc_teknik_perawatan ,
    					'gc_pelayanan_terapis' => $greq->c_pelayanan_terapis ,
    					'gc_at_brosur' => $req->gc_at_brosur ,
    					'gc_at_rekomendasi' => $req->gc_at_rekomendasi ,
    					'gc_at_spanduk' => $req->gc_at_spanduk ,
    					'gc_at_media_sosial' => $req->gc_at_media_sosial ,
    					'gc_at_lain' => $req->gc_at_lain ,
    					'gc_mungkinkah_kembali' => $req->gc_mungkinkah_kembali ,
    					'gc_ada_perlu_diperbaiki' => $req->gc_ada_perlu_diperbaiki ,
    					'gc_komen_lain' => $req->gc_komen_lain
    					)); 
    	}else{
    		$saveGC = MQ::insertGetId(array(
    					'booking_id' => $req->booking->id ,
    					'user_id' => $req->user_id ,
    					'gc_staff_pelayanan' => $req->gc_staff_pelayanan ,
    					'gc_suasana_spa' => $req->gc_suasana_spa ,
    					'gc_kebersihan_kenyamanan' => $req->gc_kebersihan_kenyamanan ,
    					'gc_teknik_perawatan' => $req->gc_teknik_perawatan ,
    					'gc_pelayanan_terapis' => $req->gc_pelayanan_terapis ,
    					'gc_ada_perlu_diperbaiki' => $req->gc_ada_perlu_diperbaiki ,
    					'gc_komen_lain' => $req->gc_komen_lain
    					));
    	}
    	if(!isset($saveGC)) return composeReply('ERROR', 'failed to generate guest comment, server error!');
    	
    	return responseSuccess(['success' => 'true', 'message' => 'berhasil mengirim guest comment!']);
    }

}
