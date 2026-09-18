<div class="ac-modal-overlay fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
  <div class="overflow-y-auto">
    <div
      class="modal box modal-inner absolute left-1/2 my-10 max-h-[90vh] w-[95%] max-w-[710px] duration-300 -translate-x-1/2 overflow-y-auto xl:p-8">
      <!-- { "translate-y-0 scale-100 opacity-100 my-10": open } -->
      <div class="relative">
        <button class="ac-modal-close-btn absolute top-0 ltr:right-0 rtl:left-0">
          <i class="las la-times"></i>
        </button>
        <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
          <h4 class="h4">Create Bank Account</h4>
        </div>
        <form>
          <p class="mb-4 text-lg font-medium">Profile Photo</p>
          <div class="mb-6 flex flex-wrap items-center gap-5 xl:gap-10">
            <img src="../images/placeholder.png" class="h-20 w-20 lg:h-auto lg:w-auto" alt="placeholder" />
            <div class="flex gap-4">
              <input type="file" name="photo" id="photo" class="hidden" />
              <label for="photo" class="btn-primary"> Upload Photo </label>
              <button class="btn-outline">Cancel</button>
            </div>
          </div>
          <div class="mt-6 grid grid-cols-2 gap-4 xl:mt-8 3xl:gap-6">
            <div class="col-span-2">
              <label for="name" class="mb-4 block font-medium md:text-lg">
                Account Holder Name
              </label>
              <input type="text" class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                placeholder="Enter Name" id="name" required />
            </div>
            <div class="col-span-2">
              <label for="number" class="mb-4 block font-medium md:text-lg">
                Phone Number
              </label>
              <input type="number" class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                placeholder="Enter Number" id="number" required />
            </div>
            <div class="col-span-2">
              <label for="currency" class="mb-4 block font-medium md:text-lg">
                Select Currency
              </label>
              <select name="currency" class="nc-select full ">
                <option value="usd">USD</option>
                <option value="gbp">GBP</option>
                <option value="yen">YEN</option>
                <option value="jpn">JPN</option>
              </select>
            </div>
            <div class="col-span-2 md:col-span-1">
              <label for="rate" class="mb-4 block font-medium md:text-lg">
                Interest Rate
              </label>
              <input type="number" class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                placeholder="Interest Rate %" id="rate" required />
            </div>
            <div class="col-span-2 md:col-span-1">
              <label for="expire" class="mb-4 block font-medium md:text-lg">
                Expiry Date
              </label>
              <div class="relative bg-secondary/5 py-3  border border-n30  rounded-3xl">
                <input type="date" class="border-none w-full px-4" placeholder="Select Date" autocomplete="off" />
              </div>
            </div>
            <div class="col-span-2">
              <label for="amount" class="mb-4 block font-medium md:text-lg">
                Amount
              </label>
              <input type="number" class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                placeholder="Enter Amount" id="amount" required />
            </div>
            <div class="col-span-2">
              <label for="status" class="mb-4 block font-medium md:text-lg">
                Select Status
              </label>
              <select name="currency" class="nc-select full ">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-span-2 mt-4">
              <button class="btn-primary flex w-full justify-center" type="submit">
                Create Account
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>