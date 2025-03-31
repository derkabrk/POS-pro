<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentType;
use App\Models\Plan;
use App\Models\User;
use App\Models\Gateway;
use App\Models\Business;
use App\Helpers\HasUploader;
use App\Models\Vat;
use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AcnooBusinessController extends Controller
{

    use HasUploader;

    public function __construct()
    {
        $this->middleware('permission:business-create')->only('create', 'store');
        $this->middleware('permission:business-read')->only('index');
        $this->middleware('permission:business-update')->only('edit', 'update', 'status');
        $this->middleware('permission:business-delete')->only('destroy', 'deleteAll');
    }

    public function index(Request $request)
    {
        $plans = Plan::latest()->get();
        $gateways = Gateway::latest()->get();
        $businesses = Business::with('enrolled_plan:id,plan_id', 'enrolled_plan.plan:id,subscriptionName', 'category:id,name')->latest()->paginate(20);
        return view('admin.business.index', compact('businesses', 'gateways', 'plans'));
    }

    public function acnooFilter(Request $request)
    {
        $search = $request->input('search'); // Get search term
        $businesses = Business::query(); // Initialize query builder
    
        // Check if type is set and not empty, and it's not "all"
        if ($request->has('type') && $request->type !== '' && $request->type !== 'all') {
            $businesses->where('type', $request->type);
        }
    
        if (!empty($search)) {
            $businesses->where(function ($q) use ($search) {
                $q->where('companyName', 'like', '%' . $search . '%')
                    ->orWhere('phoneNumber', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('enrolled_plan.plan', function ($q) use ($search) {
                        $q->where('subscriptionName', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $businesses = $businesses->latest()->paginate($request->per_page ?? 20);
    
        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.business.datas', compact('businesses'))->render()
            ]);
        }
    
        return redirect(url()->previous());
    }
    
    

    public function filter(Request $request)
    {
        $query = Business::query();

        // Apply sale_type filter if selected
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', intval($request->type));
        }
        $business = $query->latest()->paginate($request->per_page ?? 10);

        return response()->json([
            'business' => view('business::business.dates', compact('business'))->render(),
        ]);
    }

    public function create()
    {
        $plans = Plan::where('status', 1)->latest()->get();
        $categories = BusinessCategory::latest()->get();
        return view('admin.business.create', compact('plans', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'pictureUrl' => 'nullable|image|max:2024',
            'phoneNumber' => 'nullable',
            'shopOpeningBalance' => 'nullable|numeric',
            'business_category_id' => 'required|exists:business_categories,id',
            'plan_subscribe_id' => 'nullable|exists:plans,id',
            'type' => 'required|integer|in:0,1,2',
        ]);

        DB::beginTransaction();

        try {

            $user = auth()->user();

            $business = Business::create([
                'companyName' => $request->companyName,
                'address' => $request->address,
                'email' =>  $request->email,
                'phoneNumber' => $request->phoneNumber,
                'shopOpeningBalance' => $request->shopOpeningBalance,
                'business_category_id' => $request->business_category_id,
                'pictureUrl' => $request->pictureUrl ? $this->upload($request, 'pictureUrl') : NULL,
                'user_id' => $user->id,
                'type'=>  request->type,
            ]);

            $vat = Vat::create([
                'name' => "Inital",
                'business_id' => $business->id,
                'rate' =>  0,
                "status" => 1,
            ]);

            $payment_type = PaymentType::create([
                'name' => "COD",
                'business_id' => $business->id,
                "status" => 1,
            ]);

            $payment_type = PaymentType::create([
                'name' => "Cash",
                'business_id' => $business->id,
                "status" => 1,
            ]);

            User::create([
                'business_id'=>$business->id,
                'name' => $request->companyName,
                'email' =>  $request->email,
                'phone' => $request->phoneNumber,
                'image' => $request->pictureUrl ? $this->upload($request, 'pictureUrl') : NULL,
                'password' => Hash::make($request->password),
                'user_id' => $user->id,
                'lang' => 'en',
            ]);

            if ($request->plan_subscribe_id) {
                $plan = Plan::findOrFail($request->plan_subscribe_id);

                $subscribe = PlanSubscribe::create([
                    'plan_id' => $plan->id,
                    'notes' => $request->notes,
                    'duration' => $plan->duration,
                    'business_id' => $business->id,
                    'price' => $plan->subscriptionPrice,
                    'gateway_id' => $request->gateway_id,
                ]);

                $business->update([
                    'subscriptionDate' => now(),
                    'plan_subscribe_id' => $subscribe->id,
                    'will_expire' => now()->addDays($plan->duration),
                ]);

                sendNotification($subscribe->id, route('admin.subscription-reports.index', ['id' => $subscribe->id]), __('Plan subscribed by ' . $user->name));
            }

            DB::commit();

            return response()->json([
                'message' => __('Business created successfully.'),
                'redirect' => route('admin.business.index'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something went wrong.'), 403);
        }
    }

    public function show($id)
    {
        // Fetch sale details
        $businesss = Business::findOrFail($id);

        return response()->json([
            'html' => view('business::sales.show', compact('businesss',))->render()
        ]);
    }

    public function edit(string $id)
    {
        $plans = Plan::latest()->get();
        $business = Business::findOrFail($id);
        $categories = BusinessCategory::latest()->get();
        $user = User::where('business_id', $business->id)->firstOrFail();
        return view('admin.business.edit', compact('business', 'plans', 'categories','user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
            'pictureUrl' => 'nullable|image|max:2024',
            'phoneNumber' => 'nullable',
            'shopOpeningBalance' => 'nullable|numeric',
            'business_category_id' => 'required|exists:business_categories,id',
            'plan_subscribe_id' => 'nullable|exists:plans,id',
            'type' => 'required|integer|in:0,1,2',
        ]);

        DB::beginTransaction();

        try {
            
            $business = Business::findOrFail($id);

            $business->update([
                'companyName' => $request->companyName,
                'address' => $request->address,
                'phoneNumber' => $request->phoneNumber,
                'shopOpeningBalance' => $request->shopOpeningBalance,
                'business_category_id' => $request->business_category_id,
                'type'=>  $request->type,
                'pictureUrl' => $request->pictureUrl ? $this->upload($request, 'pictureUrl', $business->pictureUrl) : $business->pictureUrl,
            ]);

            $user = User::where('business_id', $business->id)->firstOrFail();
            $user->update([
                'name' => $request->companyName,
                'email' => $request->email,
                'phone' => $request->phoneNumber,
                'image' => $request->pictureUrl ? $this->upload($request, 'pictureUrl') : $user->image,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            if ($request->plan_subscribe_id) {
                $plan = Plan::findOrFail($request->plan_subscribe_id);

                $subscribe = PlanSubscribe::create([
                    'plan_id' => $plan->id,
                    'notes' => $request->notes,
                    'duration' => $plan->duration,
                    'business_id' => $business->id,
                    'price' => $plan->subscriptionPrice,
                    'gateway_id' => $request->gateway_id,
                ]);

                $business->update([
                    'subscriptionDate' => now(),
                    'plan_subscribe_id' => $subscribe->id,
                    'will_expire' => now()->addDays($plan->duration),
                ]);

                sendNotification($subscribe->id, route('admin.subscription-reports.index', ['id' => $subscribe->id]), __('Plan subscribed by ' . auth()->user()->name));
            }

            DB::commit();

            return response()->json([
                'message' => __('Business updated successfully.'),
                'redirect' => route('admin.business.index'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something went wrong.'), 403);
        }
    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return response()->json([
            'message'   => __('Business deleted successfully'),
            'redirect'  => route('admin.business.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Business::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Selected Business deleted successfully'),
            'redirect'  => route('admin.business.index')
        ]);
    }

    // Upgrade plan code

    public function upgradePlan(Request $request)
    {
        $request->validate([
            'price' => 'required|string',
            'notes' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
            'business_id' => 'required|exists:businesses,id',
            "expieryDate"=> 'required|date',
        ]);

        DB::beginTransaction();
        try {

            $plan = Plan::findOrFail($request->plan_id);
            $business = Business::findOrFail($request->business_id);

            $subscribe = PlanSubscribe::create([
                'plan_id' => $plan->id,
                'payment_status' => 'paid',
                'notes' => $request->notes,
                'duration' => $plan->duration,
                'business_id' => $business->id,
                'price' => $plan->subscriptionPrice,
                'gateway_id' => $request->gateway_id,
            ]);

            $business->update([
                'subscriptionDate' => now(),
                'plan_subscribe_id' => $subscribe->id,
                'will_expire' => $request->expieryDate,
            ]);

            sendNotification($subscribe->id, route('admin.subscription-reports.index', ['id' => $subscribe->id]), __('Plan subscribed by ' . auth()->user()->name));

            DB::commit();
            return response()->json([
                'message' => __('Subscription enrolled successfully.'),
                'redirect' => route('admin.subscription-reports.index'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong.'), 403);
        }
    }
}
