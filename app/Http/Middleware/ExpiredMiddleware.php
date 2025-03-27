<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ExpiredMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!plan_data() || !plan_data()->will_expire || plan_data()->will_expire < now()) {
            $message = __('Your plan has expired. Please subscribe to a new plan. You can only view data when your plan has expired.');

            $disabledRoutes = [
                'business.profiles.update',
                'business.sales.store',
                'business.sales.update',
                'business.sales.destroy',
                'business.sales.delete-all',
                'business.sales.mail',
                'business.sales.store.customer',
                'business.sale-returns.store',
                'business.purchases.store',
                'business.purchases.update',
                'business.purchases.destroy',
                'business.purchases.delete-all',
                'business.purchases.mail',
                'business.purchases.store.supplier',
                'business.purchase-returns.store',
                'business.products.store',
                'business.products.update',
                'business.products.destroy',
                'business.products.delete-all',
                'business.brands.store',
                'business.brands.delete-all',
                'business.brands.update',
                'business.brands.destroy',
                'business.payment-types.store',
                'business.payment-types.update',
                'business.payment-types.destroy',
                'business.payment-types.delete-all',
                'business.units.store',
                'business.units.update',
                'business.units.destroy',
                'business.units.delete-all',
                'business.categories.store',
                'business.categories.update',
                'business.categories.destroy',
                'business.categories.delete-all',
                'business.parties.store',
                'business.parties.update',
                'business.parties.destroy',
                'business.parties.delete-all',
                'business.income-categories.store',
                'business.income-categories.update',
                'business.income-categories.destroy',
                'business.income-categories.delete-all',
                'business.incomes.store',
                'business.incomes.update',
                'business.incomes.destroy',
                'business.incomes.delete-all',
                'business.expense-categories.store',
                'business.expense-categories.update',
                'business.expense-categories.destroy',
                'business.expense-categories.delete-all',
                'business.expenses.store',
                'business.expenses.update',
                'business.expenses.destroy',
                'business.expenses.delete-all',
                'business.collect.dues.store',
                'business.collect.dues.mail',
                'business.roles.store',
                'business.roles.update',
                'business.roles.destroy',
                'business.settings.update',
                'business.subscriptions.store',
                'business.subscriptions.update',
                'business.subscriptions.destroy',
                'business.currencies.default',
                'business.vats.store',
                'business.vats.update',
                'business.vats.destroy',
                'business.vats.deleteAll',
                'business.shipping.store',
                'business.shipping.update',
                'business.shipping.edit',
                'business.shipping.destroy',
                'business.shipping.deleteAll',

            ];

            if ($request->isMethod('delete')) {
                return response()->json($message, 406);
            }

            if (in_array(Route::currentRouteName(), $disabledRoutes)) {
                return $request->wantsJson()
                    ? response()->json($message, 406)
                    : redirect(route('business.subscriptions.index'))->with('error', $message);
            }
        }

        return $next($request);
    }
}
