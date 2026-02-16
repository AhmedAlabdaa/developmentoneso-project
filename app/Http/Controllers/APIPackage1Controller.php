<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class APIPackage1Controller extends Controller
{
    /**
     * Test method to ensure the controller is loaded correctly.
     */
    public function index()
    {
        return response()->json(['message' => 'APIPackage1Controller is working!'], 200);
    }

    /**
     * Store a new candidate from API data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'candidate' => 'required|array',
                'candidate.ref_no' => 'required|string',
                'candidate.first_name' => 'required|string',
                'candidate.middle_name' => 'nullable|string',
                'candidate.surname' => 'required|string',
                'candidate.passport_number' => 'required|string',
                'candidate.nationality' => 'required|string',
                'candidate.passport_expiry_date' => 'required|date',
                'candidate.passport_issue_date' => 'required|date',
                'candidate.passport_issue_place' => 'required|string',
                'candidate.date_of_birth' => 'required|date',
                'candidate.foreign_partner' => 'nullable|string',
                'candidate.branch_in_uae' => 'nullable|string',
                'candidate.age' => 'required|integer',
                'candidate.gender' => 'required|string',
                'candidate.salary' => 'required|string',
                'candidate.contract_duration' => 'required|string',
                'candidate.phone_number' => 'required|string',
                'candidate.religion' => 'nullable|string',
                'candidate.english_skills' => 'nullable|string',
                'candidate.arabic_skills' => 'nullable|string',
                'candidate.applied_position' => 'required|string',
                'candidate.work_skill' => 'nullable|string',
                'candidate.education_level' => 'nullable|string',
                'candidate.marital_status' => 'nullable|string',
                'candidate.number_of_children' => 'nullable|integer',
                'candidate.height' => 'nullable|numeric',
                'candidate.weight' => 'nullable|numeric',
                'candidate.preferred_package' => 'nullable|string',
                'candidate.desired_country' => 'nullable|string',
                'candidate.coc_status' => 'nullable|string',
                'candidate.place_of_birth' => 'nullable|string',
                'candidate.candidate_current_address' => 'nullable|string',
                'candidate.labour_id_date' => 'nullable|date',
                'candidate.labour_id_number' => 'nullable|string',
                'candidate.family_name' => 'nullable|string',
                'candidate.family_contact_number_1' => 'nullable|string',
                'candidate.family_contact_number_2' => 'nullable|string',
                'candidate.relationship_with_candidate' => 'nullable|string',
                'candidate.family_current_address' => 'nullable|string',
                'candidate.current_status' => 'nullable|integer',
                'experiences' => 'nullable|array',
                'attachments' => 'nullable|array',
            ]);

            $candidate = $validatedData['candidate'];
            $experiences = $validatedData['experiences'] ?? [];
            $attachments = $validatedData['attachments'] ?? [];

            // Check for duplicate passport number
            $existingCandidate = DB::table('new_candidates')
                ->where('passport_no', $candidate['passport_number'])
                ->first();

            if ($existingCandidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate passport number detected.',
                    'error' => 'Passport number must be unique. This number is already used.',
                ], 400);
            }

            // Generate a new reference number
            $lastReference = Cache::remember('last_reference_no', 60, function () {
                return DB::table('new_candidates')->max('reference_no');
            });

            $newReferenceNo = $lastReference ? $lastReference + 1 : 30001;

            // Prepare payload for database insertion
            $payload = [
                'reference_no' => $newReferenceNo,
                'ref_no' => $candidate['ref_no'],
                'candidate_name' => trim("{$candidate['first_name']} {$candidate['middle_name']} {$candidate['surname']}"),
                'passport_no' => $candidate['passport_number'],
                'nationality' => $candidate['nationality'],
                'passport_expiry_date' => $candidate['passport_expiry_date'],
                'passport_issue_date' => $candidate['passport_issue_date'],
                'passport_issue_place' => $candidate['passport_issue_place'],
                'date_of_birth' => $candidate['date_of_birth'],
                'foreign_partner' => $candidate['foreign_partner'],
                'branch_in_uae' => $candidate['branch_in_uae'],
                'age' => $candidate['age'],
                'gender' => $candidate['gender'],
                'salary' => $candidate['salary'],
                'contract_duration' => $candidate['contract_duration'],
                'phone_number' => $candidate['phone_number'],
                'religion' => $candidate['religion'],
                'english_skills' => $candidate['english_skills'],
                'arabic_skills' => $candidate['arabic_skills'],
                'applied_position' => $candidate['applied_position'],
                'work_skill' => $candidate['work_skill'],
                'education_level' => $candidate['education_level'],
                'marital_status' => $candidate['marital_status'],
                'number_of_children' => $candidate['number_of_children'],
                'height' => $candidate['height'],
                'weight' => $candidate['weight'],
                'preferred_package' => $candidate['preferred_package'],
                'desired_country' => $candidate['desired_country'],
                'coc_status' => $candidate['coc_status'],
                'place_of_birth' => $candidate['place_of_birth'],
                'candidate_current_address' => $candidate['candidate_current_address'],
                'labour_id_date' => $candidate['labour_id_date'],
                'labour_id_number' => $candidate['labour_id_number'],
                'family_name' => $candidate['family_name'],
                'family_contact_number_1' => $candidate['family_contact_number_1'],
                'family_contact_number_2' => $candidate['family_contact_number_2'],
                'relationship_with_candidate' => $candidate['relationship_with_candidate'],
                'family_current_address' => $candidate['family_current_address'],
                'current_status' => $candidate['current_status'] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert candidate data into the database
            DB::table('new_candidates')->insert($payload);

            // Insert experiences if provided
            if (!empty($experiences)) {
                $experiencePayload = array_map(function ($experience) use ($newReferenceNo) {
                    return [
                        'candidate_id' => $newReferenceNo,
                        'country' => $experience['country'],
                        'experience_years' => $experience['experience_years'],
                        'experience_months' => $experience['experience_months'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $experiences);

                DB::table('candidates_experience')->insert($experiencePayload);
            }

            // Insert attachments if provided
            if (!empty($attachments)) {
                $attachmentPayload = array_map(function ($attachment) use ($newReferenceNo) {
                    return [
                        'candidate_id' => $newReferenceNo,
                        'attachment_type' => $attachment['attachment_type'],
                        'attachment_file' => $attachment['attachment_file'],
                        'attachment_name' => $attachment['attachment_name'],
                        'attachment_number' => $attachment['attachment_number'],
                        'issued_on' => $attachment['issued_on'],
                        'expired_on' => $attachment['expired_on'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $attachments);

                DB::table('candidate_attachments')->insert($attachmentPayload);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Candidate saved successfully.',
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method of APIPackage1Controller: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the candidate.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
