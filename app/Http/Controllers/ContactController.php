<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exceptions\DatabaseExceptionHandler;
use Illuminate\Database\QueryException;

class ContactController extends Controller
{
    public function index()
    {
        $seoData = $this->getSeoData('pool-repair-quote', [
            'meta_title' => 'Get a Pool Repair Quote',
            'meta_description' => 'Get a free quote for pool resurfacing and repair services. Expert fiberglass and plaster resurfacing in Texas.',
        ]);

        return view('contact.pool-repair-quote', compact('seoData'));
    }

    public function store(Request $request)
    {
        try {
            // Determine form type and set appropriate validation rules
            $isHomepageForm = $request->has('type') && $request->type === 'appointment';
            $isNewsletterForm = $request->has('type') && $request->type === 'newsletter';
            $isServiceForm = $request->has('fname');
            $isContactForm = $request->has('name') && ! $isHomepageForm && ! $isServiceForm;

            if ($isHomepageForm) {
                $rules = $this->getHomepageFormRules();
                $messages = $this->getHomepageFormMessages();
            } elseif ($isNewsletterForm) {
                $rules = $this->getNewsletterFormRules();
                $messages = $this->getNewsletterFormMessages();
            } elseif ($isServiceForm) {
                $rules = $this->getServiceFormRules();
                $messages = $this->getServiceFormMessages();
            } elseif ($isContactForm) {
                $rules = $this->getContactPageFormRules();
                $messages = $this->getContactPageFormMessages();
            } else {
                $rules = $this->getContactFormRules();
                $messages = $this->getContactFormMessages();
            }

            $validatedData = $request->validate($rules, $messages);

            // Sanitize and process data
            $processedData = $this->processFormData($validatedData, $request);

            // Log the form submission for debugging
            $formType = 'contact';
            if ($isHomepageForm) {
                $formType = 'homepage';
            } elseif ($isNewsletterForm) {
                $formType = 'newsletter';
            } elseif ($isServiceForm) {
                $formType = 'service';
            }

            \Log::info('Contact form submission', [
                'type' => $formType,
                'data' => $processedData,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Save to database
            ContactSubmission::create($processedData);

            if ($isHomepageForm) {
                $successMessage = 'Thank you for your request! We will contact you shortly to schedule your callback.';
            } elseif ($isNewsletterForm) {
                $successMessage = 'Thank you for subscribing to our newsletter!';
            } elseif ($isContactForm) {
                $successMessage = 'Thank you for your message! We will get back to you soon.';
            } else {
                $successMessage = 'Thank you for your message! We will get back to you soon.';
            }

            return back()->with('success', $successMessage);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below and try again.');

        } catch (QueryException $e) {
            // Handle database-specific errors
            $errorInfo = DatabaseExceptionHandler::handle($e);
            
            Log::error('Database error in contact form submission', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'ip' => $request->ip(),
                'type' => $request->input('type', 'unknown'),
            ]);

            return back()
                ->withInput()
                ->with('error', $errorInfo['user_message']);
                
        } catch (\Exception $e) {
            // Handle all other errors
            Log::error('Contact form submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->except(['_token']),
                'ip' => $request->ip(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error processing your request. Please try again or contact us directly.');
        }
    }

    private function getHomepageFormRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone' => ['required', 'string', 'max:20', 'min:10', function ($attribute, $value, $fail) {
                // Remove all non-numeric characters to check area code
                $numbersOnly = preg_replace('/[^0-9]/', '', $value);

                // Check minimum digits
                if (strlen($numbersOnly) < 10) {
                    $fail('Phone number must be at least 10 digits.');
                    return;
                }

                // Check if phone starts with blocked area codes
                $blockedAreaCodes = ['123', '000', '111', '555'];
                $areaCode = substr($numbersOnly, 0, 3);
                
                if (in_array($areaCode, $blockedAreaCodes)) {
                    $fail("Area code {$areaCode} is not valid. Please enter a valid phone number.");
                    return;
                }

                // Additional check for US format starting with +1
                if (strlen($numbersOnly) >= 4 && substr($numbersOnly, 0, 1) === '1') {
                    $usAreaCode = substr($numbersOnly, 1, 3);
                    if (in_array($usAreaCode, $blockedAreaCodes)) {
                        $fail("Area code {$usAreaCode} is not valid. Please enter a valid phone number.");
                    }
                }
            }],
            'address' => ['nullable', 'email:rfc', 'max:255'],
            'service' => 'required|string|in:request-callback,pool-resurfacing-conversion,pool-repair,pool-remodeling',
            'g-recaptcha-response' => [config('recaptcha.enabled') ? 'required' : 'nullable', new Recaptcha()],
            'message' => ['nullable', 'string', 'max:1000', 'min:10', function ($attribute, $value, $fail) {
                if (!empty($value) && strlen(trim($value)) < 10) {
                    $fail('Message must be at least 10 characters if provided.');
                }
            }],
        ];
    }

    private function getNewsletterFormRules(): array
    {
        return [
            'email' => 'required|email:rfc|max:255',
            'g-recaptcha-response' => [config('recaptcha.enabled') ? 'required' : 'nullable', new Recaptcha()],
        ];
    }

    private function getNewsletterFormMessages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address is too long.',
        ];
    }

    private function getHomepageFormMessages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'phone.required' => 'Phone number is required.',
            'phone.min' => 'Please enter a valid phone number.',
            'phone.max' => 'Phone number is too long.',
            'address.email' => 'Please enter a valid email address.',
            'service.required' => 'Please select a service.',
            'service.in' => 'Please select a valid service option.',
            'message.min' => 'Notes must be at least 10 characters if provided.',
            'message.max' => 'Notes cannot exceed 1000 characters.',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ];
    }

    private function getServiceFormRules(): array
    {
        return [
            'fname' => 'required|string|max:255|min:2',
            'pnumber' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000|min:10',
        ];
    }

    private function getServiceFormMessages(): array
    {
        return [
            'fname.required' => 'Please enter your name.',
            'fname.min' => 'Name must be at least 2 characters.',
            'message.required' => 'Please enter a message.',
            'message.min' => 'Message must be at least 10 characters.',
        ];
    }

    private function getContactPageFormRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'phone' => ['required', 'string', 'max:20', 'min:10', function ($attribute, $value, $fail) {
                // Remove all non-numeric characters to check
                $numbersOnly = preg_replace('/[^0-9]/', '', $value);

                // Check minimum digits
                if (strlen($numbersOnly) < 10) {
                    $fail('Phone number must be at least 10 digits.');
                }
            }],
            'address' => ['nullable', 'email:rfc', 'max:255'],
            'service' => 'required|string|in:request-callback,pool-resurfacing-conversion,pool-repair,pool-remodeling',
            'g-recaptcha-response' => [config('recaptcha.enabled') ? 'required' : 'nullable', new Recaptcha()],
            'message' => ['nullable', 'string', 'max:1000', 'min:10', function ($attribute, $value, $fail) {
                if (!empty($value) && strlen(trim($value)) < 10) {
                    $fail('Message must be at least 10 characters if provided.');
                }
            }],
        ];
    }

    private function getContactPageFormMessages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'phone.required' => 'Phone number is required.',
            'phone.min' => 'Please enter a valid phone number.',
            'phone.max' => 'Phone number is too long.',
            'address.email' => 'Please enter a valid email address.',
            'service.required' => 'Please select a service.',
            'service.in' => 'Please select a valid service option.',
            'message.min' => 'Notes must be at least 10 characters if provided.',
            'message.max' => 'Notes cannot exceed 1000 characters.',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ];
    }

    private function getContactFormRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s\'\-]+$/'],
            'email' => 'required|email:rfc|max:255',
            'message' => 'required|string|max:1000|min:10',
        ];
    }

    private function getContactFormMessages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please enter a message.',
            'message.min' => 'Message must be at least 10 characters.',
        ];
    }

    private function processFormData(array $validatedData, Request $request): array
    {
        $processedData = $validatedData;

        // Sanitize text inputs and split names
        if (isset($processedData['name'])) {
            $processedData['name'] = strip_tags(trim($processedData['name']));
            // Split full name into first and last names
            $this->splitName($processedData['name'], $processedData);
        }
        if (isset($processedData['fname'])) {
            $processedData['fname'] = strip_tags(trim($processedData['fname']));
            $processedData['name'] = $processedData['fname']; // Map for consistency
            // Split full name into first and last names
            $this->splitName($processedData['name'], $processedData);
        }
        if (isset($processedData['message'])) {
            $trimmedMessage = trim($processedData['message']);
            if (! empty($trimmedMessage)) {
                $processedData['message'] = strip_tags($trimmedMessage);
            } else {
                $processedData['message'] = null; // Set to null for empty messages
            }
        } else {
            $processedData['message'] = null; // Set to null if not provided
        }

        // Handle phone number formatting
        if (isset($processedData['phone'])) {
            $processedData['phone'] = preg_replace('/[^0-9+\-\(\)\s]/', '', $processedData['phone']);
        }
        if (isset($processedData['pnumber'])) {
            $processedData['pnumber'] = preg_replace('/[^0-9+\-\(\)\s]/', '', $processedData['pnumber']);
            $processedData['phone'] = $processedData['pnumber']; // Map for consistency
        }

        // Handle email mapping for homepage form
        if (isset($processedData['address']) && filter_var($processedData['address'], FILTER_VALIDATE_EMAIL)) {
            $processedData['email'] = $processedData['address'];
        } elseif (! isset($processedData['email'])) {
            $processedData['email'] = 'no-email@'.request()->getHost();
        }

        // Add metadata
        if ($request->has('type') && $request->type === 'newsletter') {
            $processedData['source'] = 'newsletter';
            // For newsletter, set default values for required fields
            $processedData['name'] = 'Newsletter Subscriber';
            $processedData['first_name'] = 'Newsletter';
            $processedData['last_name'] = 'Subscriber';
            $processedData['message'] = 'Newsletter subscription request';
        } elseif ($request->has('source') && ! empty($request->source)) {
            // Always respect the explicitly provided source parameter
            $processedData['source'] = $request->source;
        } elseif ($request->has('fname')) {
            // Service form detection (has fname field)
            $processedData['source'] = 'service_form';
        } elseif ($request->has('type') && $request->type === 'appointment') {
            // Default homepage form for appointment type without explicit source
            $processedData['source'] = 'homepage_form';
        } else {
            // Default to contact page
            $processedData['source'] = 'contact_page';
        }
        $processedData['ip_address'] = $request->ip();
        $processedData['user_agent'] = $request->userAgent();
        $processedData['submitted_at'] = now();

        // Add source URI
        $processedData['source_uri'] = $request->fullUrl();

        // Service field is already correctly named 'service' in the database
        // No need to rename it

        return $processedData;
    }

    public function investorRelations()
    {
        $seoData = $this->getSeoData('investor_relations', [
            'meta_title' => 'Investor Relations - Growth Opportunities',
            'meta_description' => 'Explore investment opportunities with Hexagon Service Solutions. Join us in expanding professional cleaning services.',
        ]);

        return view('investor-relations', compact('seoData'));
    }

    public function storeInvestorInquiry(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|min:10',
                'company' => 'nullable|string|max:255',
                'investment_interest' => 'required|string|in:franchise,partnership,capital_investment,general_inquiry',
                'investment_amount' => 'nullable|string|in:under_50k,50k_100k,100k_250k,250k_500k,over_500k',
                'message' => 'nullable|string|max:2000',
            ];

            $messages = [
                'name.required' => 'Please enter your full name.',
                'name.min' => 'Name must be at least 2 characters.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'phone.required' => 'Please enter your phone number.',
                'phone.min' => 'Please enter a valid phone number.',
                'investment_interest.required' => 'Please select your area of investment interest.',
                'investment_interest.in' => 'Please select a valid investment interest.',
                'investment_amount.in' => 'Please select a valid investment amount range.',
                'message.max' => 'Message cannot exceed 2000 characters.',
            ];

            $validatedData = $request->validate($rules, $messages);

            // Process the investor inquiry data
            $processedData = $this->processInvestorData($validatedData, $request);

            // Log the investor inquiry
            \Log::info('Investor inquiry submission', [
                'data' => $processedData,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Save to database
            ContactSubmission::create($processedData);

            return back()->with('success', 'Thank you for your interest! Our investor relations team will contact you within 24 hours to discuss opportunities.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below and try again.');

        } catch (\Exception $e) {
            \Log::error('Investor inquiry submission error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
                'ip' => $request->ip(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error processing your request. Please try again or contact us directly.');
        }
    }

    private function processInvestorData(array $validatedData, Request $request): array
    {
        $processedData = $validatedData;

        // Sanitize text inputs
        if (isset($processedData['name'])) {
            $processedData['name'] = strip_tags(trim($processedData['name']));
            $this->splitName($processedData['name'], $processedData);
        }

        if (isset($processedData['company'])) {
            $processedData['company'] = strip_tags(trim($processedData['company']));
        }

        if (isset($processedData['message'])) {
            $trimmedMessage = trim($processedData['message']);
            if (!empty($trimmedMessage)) {
                $processedData['message'] = strip_tags($trimmedMessage);
            } else {
                $processedData['message'] = null;
            }
        } else {
            $processedData['message'] = null;
        }

        // Handle phone number formatting
        if (isset($processedData['phone'])) {
            $processedData['phone'] = preg_replace('/[^0-9+\-\(\)\s]/', '', $processedData['phone']);
        }

        // Add metadata specific to investor inquiries
        $processedData['source'] = 'investor_relations_page';
        $processedData['ip_address'] = $request->ip();
        $processedData['user_agent'] = $request->userAgent();
        $processedData['submitted_at'] = now();
        $processedData['source_uri'] = $request->fullUrl();
        
        // Create a detailed service description for investor inquiries
        $interestLabels = [
            'franchise' => 'Franchise Opportunities',
            'partnership' => 'Strategic Partnership',
            'capital_investment' => 'Capital Investment',
            'general_inquiry' => 'General Inquiry'
        ];
        
        $amountLabels = [
            'under_50k' => 'Under $50,000',
            '50k_100k' => '$50,000 - $100,000',
            '100k_250k' => '$100,000 - $250,000',
            '250k_500k' => '$250,000 - $500,000',
            'over_500k' => 'Over $500,000'
        ];

        $serviceDescription = 'Investor Inquiry: ' . ($interestLabels[$processedData['investment_interest']] ?? $processedData['investment_interest']);
        
        if (isset($processedData['investment_amount']) && !empty($processedData['investment_amount'])) {
            $serviceDescription .= ' | Investment Range: ' . ($amountLabels[$processedData['investment_amount']] ?? $processedData['investment_amount']);
        }
        
        if (isset($processedData['company']) && !empty($processedData['company'])) {
            $serviceDescription .= ' | Company: ' . $processedData['company'];
        }

        $processedData['service'] = $serviceDescription;

        return $processedData;
    }

    private function splitName(string $fullName, array &$processedData): void
    {
        // Remove titles and prefixes
        $cleanName = preg_replace('/^(mr\.?|mrs\.?|ms\.?|dr\.?|prof\.?)\s+/i', '', trim($fullName));

        // Split by spaces and filter out empty parts
        $nameParts = array_filter(explode(' ', $cleanName), function ($part) {
            return ! empty(trim($part));
        });

        if (count($nameParts) >= 2) {
            // First name is the first part
            $processedData['first_name'] = $nameParts[0];

            // Last name is everything else joined together
            $processedData['last_name'] = implode(' ', array_slice($nameParts, 1));
        } elseif (count($nameParts) == 1) {
            // Only one name provided - use it as first name
            $processedData['first_name'] = $nameParts[0];
            $processedData['last_name'] = '';
        } else {
            // No valid name parts found
            $processedData['first_name'] = '';
            $processedData['last_name'] = '';
        }
    }
}
