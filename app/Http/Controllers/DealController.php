<?php

namespace App\Http\Controllers;

use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Models\Deal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index()
    {
        $clientId = '0fe1cffa-771b-4e72-bd6d-b0bf29ffce0f';
        $clientSecret = 'PqGhyY79XeU4OdFin29GD2QZyppJp8MWK0OvKrFvom3OZQnB5PDSA5ZXyuMIJ4AB';
        $redirectUri = 'https://vmakeevq.amocrm.ru';
        $code = 'def50200dae9e4d329ec4432095ab2fcfeaa198112c1d4e06399561a5aa3220e92812bac9b523efd2b880d4667f9db772d4273e960294d64a31e87314d3e77bccd3b682b9b2bc2d45e79d464aaed03a314f2556e58c9eb892cbde61cccb06ae64bf02bd37b560c9a169dcd90fa2ee008366204835c7506d3fcef78b72d33d0453955aa37e6c6fb31fba05653397916b83671ba0cef9680befb574cbc73b1e0c3a1c3a4dcff367c9ff0596d3ca205b7369b583582637b54ab300f6f393d3f089decc60c65036d8e0fe80d6d9b391a2cacf69ecd5c745a6da5fbdfcd5023e08fa560f16c771ff63e38d6d321c6f58432d28ed3ebd9b12d92f2867ff2dc6eca84dbd2d025be7955dceecf1e31b1bc63b6acbef60efe5ea07dff570d2c99d5ded8051cf84b4d99f2987e072796e24f813dc69e90fba838f4d7b99290c6249ee1bfd0f457bd4693b1e85d05e8427f59758717bccbffe643479668d9f6fe397e1ebdf94a7241ee2f045ff53f84fc1ccc2887c758581ae3524bd35724866889e9d4952a34f8719c724f4cce8a80ecde1515b5ce2f185a399ed8fca58615335a19ba8ddf170c6d9f7da268cd9f84c3f4c109c8dc0a46c05403fa062227dc068cca4f2f0489092c60071f47b6c0c191e279600f16b902135c966e617070225d';
        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $apiClient->setAccountBaseDomain('vmakeevq.amocrm.ru');

        try {
            $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($code);
        } catch (AmoCRMoAuthApiException $e) {
            dd($e);
        }
        $apiClient->setAccessToken($accessToken);
        $leadService = $apiClient->leads();
        $leadsCollection = $leadService->get();
        foreach ($leadsCollection as $lead) {
            Deal::create([
                'name' => $lead->name,
                'responsibleUserId' => $lead->responsibleUserId,
                'groupId' => $lead->groupId,
                'createdBy' => $lead->createdBy,
                'updatedBy' => $lead->updatedBy,
                'created_at' => $lead->createdAt,
                'updated_at' => $lead->updatedAt,
                'accountId' => $lead->accountId,
                'pipelineId' => $lead->pipelineId,
                'statusId' => $lead->statusId,
                'closedAt' => $lead->closedAt,
                'closestTaskAt' => $lead->closestTaskAt,
                'price' => $lead->price,
                'lossReasonId' => $lead->lossReasonId,
                'lossReason' => $lead->lossReason,
                'isDeleted' => $lead->isDeleted,
                'tags' => $lead->tags,
                'companyId' => $lead->company->id
            ]);
        }
        return view('index');
    }
}
