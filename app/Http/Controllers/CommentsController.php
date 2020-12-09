<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function getComments() {
        $commentsDb = Comments::with('childrenComments')->where('comment_id', 0)->orderBy('created_at', 'desc')->get();
        return $commentsDb;
    }

    public function storeComment(Request $request) {

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $checkBadWords = $this->checkBadWords($request->input('comment'));

        if($checkBadWords['is-bad']) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'comment' => ["Please don't use any bad words."]
                ]
            ], 422);
        }

        $comment = new Comments([
            'comment' => $request->input('comment'),
            'comment_id' => 0
        ]);
        $comment->save();

        return response()->json(['message' => 'The comment successfully added']);
    }

    public function storeReplyComment(Request $request) {

        $this->validate($request, [
            'comment' => 'required',
            'comment_id' => 'required',
        ]);

        $checkBadWords = $this->checkBadWords($request->input('comment'));

        if($checkBadWords['is-bad']) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'comment' => ["Please don't use any bad words."]
                ]
            ], 422);
        }

        $comment = new Comments([
            'comment' => $request->input('comment'),
            'comment_id' => $request->input('comment_id')
        ]);
        $comment->save();

        return response()->json(['message' => 'The reply comment successfully added']);
    }

    private function checkBadWords($comment) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://neutrinoapi-bad-word-filter.p.rapidapi.com/bad-word-filter",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "censor-character=*&content=". urlencode($comment),
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded",
                "x-rapidapi-host: neutrinoapi-bad-word-filter.p.rapidapi.com",
                "x-rapidapi-key: 9a6b1c8d8emsh06857fbef689d3ep11e975jsn51e803aabd32"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}
