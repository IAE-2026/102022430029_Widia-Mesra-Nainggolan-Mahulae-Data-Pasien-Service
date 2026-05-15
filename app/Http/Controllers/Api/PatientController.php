<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PatientController extends Controller
{
    #[OA\Get(
        path: "/api/v1/patients",
        summary: "Ambil semua data pasien",
        security: [["ApiKeyAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Success"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function index()
    {
        $patients = Patient::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $patients,
            'meta' => [
                'service_name' => 'Patient-Service',
                'api_version' => 'v1'
            ]
        ], 200);
    }

    #[OA\Get(
        path: "/api/v1/patients/{id}",
        summary: "Ambil data pasien by ID",
        security: [["ApiKeyAuth" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Success"),
            new OA\Response(response: 404, description: "Patient not found"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found',
                'errors' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $patient,
            'meta' => [
                'service_name' => 'Patient-Service',
                'api_version' => 'v1'
            ]
        ], 200);
    }

    #[OA\Post(
        path: "/api/v1/patients",
        summary: "Registrasi pasien baru",
        security: [["ApiKeyAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "nik", "phone", "birth_date", "address"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Widia Mesra"),
                    new OA\Property(property: "nik", type: "string", example: "102022430029"),
                    new OA\Property(property: "phone", type: "string", example: "082276162672"),
                    new OA\Property(property: "birth_date", type: "string", example: "2007-01-13"),
                    new OA\Property(property: "address", type: "string", example: "Medan"),
                    new OA\Property(property: "allergies", type: "string", example: "Buah")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Patient created"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function store(Request $request)
    {
        $patient = Patient::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Patient registered successfully',
            'data' => $patient,
            'meta' => [
                'service_name' => 'Patient-Service',
                'api_version' => 'v1'
            ]
        ], 201);
    }
}