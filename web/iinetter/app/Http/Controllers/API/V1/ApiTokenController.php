<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ApiTokenController
 * @package App\Http\Controllers\API\V1
 */

class ApiTokenController extends Controller
{
    /**
     * 認証済みのユーザーのAPIトークンを更新する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     * 
     * @SWG\Put(
     *      path="/api_token",
     *      summary="Update token",
     *      tags={"Auth"},
     *      description="Update token",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  description="token",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @SWG\SecurityScheme(
     *      securityDefinition="apiToken",
     *      type="apiKey",
     *      name="api_token",
     *      in="query"
     * )
     */
    public function update(Request $request)
    {
        return new JsonResponse(self::updateApiToken($request), 200);
    }

    /**
     * update api_token
     *
     * @param Request $request
     * @return array
     */
    public static function updateApiToken(Request $request): array
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }
}
