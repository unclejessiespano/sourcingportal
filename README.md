## Creating a new tenant
### Create the tenant
You can create a tenant by running the following command in artisan tinker.

`$tenant = App\Models\Tenant::create(['id'=>'TENANT_NAME']);`

`$tenant->domains()->create(['domain'=>'TENANT_NAME.domain.com']);`
### Add a user

### Seed the database
Seed the database by running the following command:

``

### Map the columns

## When a new order is uploaded
### Check for these changes

#### Does the line exist?
If the line doesn't exist it may mean that the line was delivered or cancelled.

#### Did the quantity change?
If the quantity descreased it means that the supplier shipped some of the pieces, update their score appropriately

#### Did the due date change?
Why did the due date change? Did it slip? If so, adjust the supplier score accordingly
