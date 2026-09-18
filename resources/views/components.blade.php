@extends('layout.main')

@section('content')
  <div class="main-inner">
    <h2 class="mb-6 xl:mb-8">Components</h2>
    <div class="space-y-4 xl:space-y-6">
      <!-- Accordion -->
      <div class="white-box">
        <h4 class="mb-4">Accordion</h4>
        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="accordion w-full max-w-3xl space-y-3">
                <div class="accordion-item bg-primary/5 border border-n30  rounded-lg overflow-hidden">
                  <div class="accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Section 1</h2>
                    <svg class="accordion-arrow w-6 h-6 transition-transform duration-300" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </div>
                  <div class="accordion-content transition-all bg-n0  duration-300 ease-in-out">
                    <div class="px-3 py-2">
                      <p>Content for section 1 goes here. You can add any HTML content inside this div. You can add any
                        HTML content inside this div. This is the third section. You can add any HTML content inside this
                        div.</p>
                    </div>
                  </div>
                </div>

                <div class="accordion-item bg-primary/5 border border-n30  rounded-lg overflow-hidden">
                  <div class="accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Section 2</h2>
                    <svg class="accordion-arrow w-6 h-6 transition-transform duration-300" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </div>
                  <div class="accordion-content transition-all bg-n0  duration-300 ease-in-out">
                    <div class="px-3 py-2">
                      <p>Content for section 2 goes here. You can add any HTML content inside this div. You can add any
                        HTML content inside this div. This is the third section. You can add any HTML content inside this
                        div.</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-primary/5 border border-n30  rounded-lg overflow-hidden">
                  <div class="accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Section 3</h2>
                    <svg class="accordion-arrow w-6 h-6 transition-transform duration-300" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </div>
                  <div class="accordion-content transition-all bg-n0  duration-300 ease-in-out">
                    <div class="px-3 py-2">
                      <p>Content for section 3 goes here. You can add any HTML content inside this div. This is the third
                        section. You can add any HTML content inside this div.</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item bg-primary/5 border border-n30  rounded-lg overflow-hidden">
                  <div class="accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Section 4</h2>
                    <svg class="accordion-arrow w-6 h-6 transition-transform duration-300" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </div>
                  <div class="accordion-content transition-all bg-n0  duration-300 ease-in-out">
                    <div class="px-3 py-2">
                      <p>Content for section 4 goes here. You can add any HTML content inside this div. this is the
                        content for section 4 goes here. You can add any HTML content inside this div.</p>
                    </div>
                  </div>
                </div>

                <!-- Add more accordion items as needed -->
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">&#x3C;div class=&#x22;accordion w-full max-w-3xl space-y-3&#x22;&#x3E;
                      &#x3C;div class=&#x22;accordion-item bg-primary/5 border border-n30   rounded-lg overflow-hidden&#x22;&#x3E;
                      &#x3C;div class=&#x22;accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center&#x22;&#x3E;
                        &#x3C;h2 class=&#x22;text-lg font-semibold&#x22;&#x3E;Section 1&#x3C;/h2&#x3E;
                        &#x3C;svg class=&#x22;accordion-arrow w-6 h-6 transition-transform duration-300&#x22; fill=&#x22;none&#x22; stroke=&#x22;currentColor&#x22; viewBox=&#x22;0 0 24 24&#x22; xmlns=&#x22;http://www.w3.org/2000/svg&#x22;&#x3E;
                          &#x3C;path stroke-linecap=&#x22;round&#x22; stroke-linejoin=&#x22;round&#x22; stroke-width=&#x22;2&#x22; d=&#x22;M19 9l-7 7-7-7&#x22;&#x3E;&#x3C;/path&#x3E;
                        &#x3C;/svg&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-content transition-all bg-n0  duration-300 ease-in-out&#x22;&#x3E;
                        &#x3C;div class=&#x22;px-3 py-2&#x22;&#x3E;
                          &#x3C;p&#x3E;Content for section 1 goes here. You can add any HTML content inside this div. You can add any HTML content inside this div. This is the third section. You can add any HTML content inside this div.&#x3C;/p&#x3E;
                        &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;

                      &#x3C;div class=&#x22;accordion-item bg-primary/5 border border-n30   rounded-lg overflow-hidden&#x22;&#x3E;
                      &#x3C;div class=&#x22;accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center&#x22;&#x3E;
                        &#x3C;h2 class=&#x22;text-lg font-semibold&#x22;&#x3E;Section 2&#x3C;/h2&#x3E;
                        &#x3C;svg class=&#x22;accordion-arrow w-6 h-6 transition-transform duration-300&#x22; fill=&#x22;none&#x22; stroke=&#x22;currentColor&#x22; viewBox=&#x22;0 0 24 24&#x22; xmlns=&#x22;http://www.w3.org/2000/svg&#x22;&#x3E;
                          &#x3C;path stroke-linecap=&#x22;round&#x22; stroke-linejoin=&#x22;round&#x22; stroke-width=&#x22;2&#x22; d=&#x22;M19 9l-7 7-7-7&#x22;&#x3E;&#x3C;/path&#x3E;
                        &#x3C;/svg&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-content transition-all bg-n0  duration-300 ease-in-out&#x22;&#x3E;
                        &#x3C;div class=&#x22;px-3 py-2&#x22;&#x3E;
                          &#x3C;p&#x3E;Content for section 2 goes here. You can add any HTML content inside this div. You can add any HTML content inside this div. This is the third section. You can add any HTML content inside this div.&#x3C;/p&#x3E;
                        &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-item bg-primary/5 border border-n30   rounded-lg overflow-hidden&#x22;&#x3E;
                      &#x3C;div class=&#x22;accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center&#x22;&#x3E;
                        &#x3C;h2 class=&#x22;text-lg font-semibold&#x22;&#x3E;Section 3&#x3C;/h2&#x3E;
                        &#x3C;svg class=&#x22;accordion-arrow w-6 h-6 transition-transform duration-300&#x22; fill=&#x22;none&#x22; stroke=&#x22;currentColor&#x22; viewBox=&#x22;0 0 24 24&#x22; xmlns=&#x22;http://www.w3.org/2000/svg&#x22;&#x3E;
                          &#x3C;path stroke-linecap=&#x22;round&#x22; stroke-linejoin=&#x22;round&#x22; stroke-width=&#x22;2&#x22; d=&#x22;M19 9l-7 7-7-7&#x22;&#x3E;&#x3C;/path&#x3E;
                        &#x3C;/svg&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-content transition-all bg-n0  duration-300 ease-in-out&#x22;&#x3E;
                        &#x3C;div class=&#x22;px-3 py-2&#x22;&#x3E;
                          &#x3C;p&#x3E;Content for section 3 goes here. You can add any HTML content inside this div. This is the third section. You can add any HTML content inside this div.&#x3C;/p&#x3E;
                        &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-item bg-primary/5 border border-n30   rounded-lg overflow-hidden&#x22;&#x3E;
                      &#x3C;div class=&#x22;accordion-header cursor-pointer bg-primary/5 px-4 py-3 flex justify-between items-center&#x22;&#x3E;
                        &#x3C;h2 class=&#x22;text-lg font-semibold&#x22;&#x3E;Section 4&#x3C;/h2&#x3E;
                        &#x3C;svg class=&#x22;accordion-arrow w-6 h-6 transition-transform duration-300&#x22; fill=&#x22;none&#x22; stroke=&#x22;currentColor&#x22; viewBox=&#x22;0 0 24 24&#x22; xmlns=&#x22;http://www.w3.org/2000/svg&#x22;&#x3E;
                          &#x3C;path stroke-linecap=&#x22;round&#x22; stroke-linejoin=&#x22;round&#x22; stroke-width=&#x22;2&#x22; d=&#x22;M19 9l-7 7-7-7&#x22;&#x3E;&#x3C;/path&#x3E;
                        &#x3C;/svg&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;accordion-content transition-all bg-n0  duration-300 ease-in-out&#x22;&#x3E;
                        &#x3C;div class=&#x22;px-3 py-2&#x22;&#x3E;
                          &#x3C;p&#x3E;Content for section 4 goes here. You can add any HTML content inside this div. this is the content for section 4 goes here. You can add any HTML content inside this div. &#x3C;/p&#x3E;
                        &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;

                      &#x3C;!-- Add more accordion items as needed --&#x3E;
                      &#x3C;/div&#x3E;
                      </code>
                                        </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Alerts -->
      <div class="white-box">
        <h4 class="mb-4">Alert</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex flex-col gap-4 lg:gap-6 pt-5">
                <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-primary/20 flex justify-between items-center">
                  <div class="flex gap-5 items-center">
                    <i class="las la-info-circle text-3xl text-primary"></i>
                    <span class="l-text font-medium text-primary">This is an primary alert — check it out!</span>
                  </div>
                  <span class="cursor-pointer size-9 rounded-full hover:bg-primary/30 duration-300 f-center">
                    <i class="las la-times text-2xl text-primary"></i>
                  </span>
                </div>
                <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-secondary/20 flex justify-between items-center">
                  <div class="flex gap-5 items-center">
                    <i class="las la-check-circle text-3xl text-secondary"></i>
                    <span class="l-text font-medium text-secondary">This is an Secondary alert — check it out!</span>
                  </div>
                  <span class="cursor-pointer size-9 rounded-full hover:bg-secondary/30 duration-300 f-center">
                    <i class="las la-times text-2xl text-secondary"></i>
                  </span>
                </div>
                <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-error/20 flex justify-between items-center">
                  <div class="flex gap-5 items-center">
                    <i class="las la-exclamation-triangle text-3xl text-error"></i>
                    <span class="l-text font-medium text-error">This is an error alert — check it out!</span>
                  </div>
                  <span class="cursor-pointer size-9 rounded-full hover:bg-error/30 duration-300 f-center">
                    <i class="las la-times text-2xl text-error"></i>
                  </span>
                </div>
                <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-warning/20 flex justify-between items-center">
                  <div class="flex gap-5 items-center">
                    <i class="las la-times-circle text-3xl text-warning"></i>
                    <span class="l-text font-medium text-warning">This is an warning alert — check it out!</span>
                  </div>
                  <span class="cursor-pointer size-9 rounded-full hover:bg-warning/30 duration-300 f-center">
                    <i class="las la-times text-2xl text-warning"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">&#x3C;div class=&#x22;flex flex-col gap-4 lg:gap-6 pt-5&#x22;&#x3E;
                      &#x3C;div class=&#x22;py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-primary/20 flex justify-between items-center&#x22;&#x3E;
                      &#x3C;div class=&#x22;flex gap-5 items-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-info-circle text-3xl text-primary&#x22;&#x3E;&#x3C;/i&#x3E;
                        &#x3C;span class=&#x22;l-text font-medium text-primary&#x22;&#x3E;This is an primary alert &#x2014; check it out!&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;span class=&#x22;cursor-pointer size-9 rounded-full hover:bg-primary/30 duration-300 f-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times text-2xl text-primary&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-secondary/20 flex justify-between items-center&#x22;&#x3E;
                      &#x3C;div class=&#x22;flex gap-5 items-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-check-circle text-3xl text-secondary&#x22;&#x3E;&#x3C;/i&#x3E;
                        &#x3C;span class=&#x22;l-text font-medium text-secondary&#x22;&#x3E;This is an Secondary alert &#x2014; check it out!&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;span class=&#x22;cursor-pointer size-9 rounded-full hover:bg-secondary/30 duration-300 f-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times text-2xl text-secondary&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-error/20 flex justify-between items-center&#x22;&#x3E;
                      &#x3C;div class=&#x22;flex gap-5 items-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-exclamation-triangle text-3xl text-error&#x22;&#x3E;&#x3C;/i&#x3E;
                        &#x3C;span class=&#x22;l-text font-medium text-error&#x22;&#x3E;This is an error alert &#x2014; check it out!&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;span class=&#x22;cursor-pointer size-9 rounded-full hover:bg-error/30 duration-300 f-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times text-2xl text-error&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-warning/20 flex justify-between items-center&#x22;&#x3E;
                      &#x3C;div class=&#x22;flex gap-5 items-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times-circle text-3xl text-warning&#x22;&#x3E;&#x3C;/i&#x3E;
                        &#x3C;span class=&#x22;l-text font-medium text-warning&#x22;&#x3E;This is an warning alert &#x2014; check it out!&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;span class=&#x22;cursor-pointer size-9 rounded-full hover:bg-warning/30 duration-300 f-center&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times text-2xl text-warning&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;   </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Avatar -->
      <div class="white-box">
        <h4 class="mb-4">Avatar</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex gap-4">
                <img class="size-10 rounded-full" src="./assets/images/avatar-1.png" alt="" />
                <img class="size-10 rounded-full" src="./assets/images/avatar-2.png" alt="" />
                <img class="size-10 rounded-full" src="./assets/images/avatar-3.png" alt="" />
                <div class="size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-primary">
                  <i class="las la-user-circle text-2xl text-n0"></i>
                </div>
                <div class="size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-secondary">
                  <i class="las la-user-circle text-2xl text-n0"></i>
                </div>
                <div class="size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-warning">
                  <i class="las la-user-circle text-2xl text-n0"></i>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">&#x3C;div class=&#x22;flex gap-4&#x22;&#x3E;
                      &#x3C;img class=&#x22;size-10 rounded-full&#x22; src=&#x22;./assets/images/avatar-1.png&#x22; alt=&#x22;&#x22; /&#x3E;
                      &#x3C;img class=&#x22;size-10 rounded-full&#x22; src=&#x22;./assets/images/avatar-2.png&#x22; alt=&#x22;&#x22; /&#x3E;
                      &#x3C;img class=&#x22;size-10 rounded-full&#x22; src=&#x22;./assets/images/avatar-3.png&#x22; alt=&#x22;&#x22; /&#x3E;
                      &#x3C;div class=&#x22;size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-primary&#x22;&#x3E;
                      &#x3C;i class=&#x22;las la-user-circle text-2xl text-n0&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-secondary&#x22;&#x3E;
                      &#x3C;i class=&#x22;las la-user-circle text-2xl text-n0&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;size-8 lg:size-10 rounded-full f-center text-neutral-0 bg-warning&#x22;&#x3E;
                      &#x3C;i class=&#x22;las la-user-circle text-2xl text-n0&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;  </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Badges -->
      <div class="white-box">
        <h4 class="mb-4">Badges</h4>
        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex gap-4 lg:gap-6 flex-wrap">
                <div class="relative">
                  <span
                    class="absolute -top-0.5 -right-1.5 text-[10px] rounded-full size-4 bg-primary text-white f-center font-bold">5</span>
                  <i class="las la-bell text-4xl"></i>
                </div>
                <div class="relative">
                  <span
                    class="absolute -top-0.5 -right-1.5 text-[10px] rounded-full size-4 bg-secondary text-white f-center font-bold">5</span>
                  <i class="las la-bell text-4xl"></i>
                </div>
                <div class="relative size-10 rounded-full bg-n50 ">
                  <span
                    class="absolute bottom-0 f-center size-4 right-0 text-n0 bg-secondary rounded-full border border-n0 ">
                    <i class="las la-clock text-xs"></i>
                  </span>
                </div>
                <div class="relative size-10 rounded-full bg-n50 ">
                  <span
                    class="absolute bottom-0 f-center size-4 right-0 text-n0 bg-primary rounded-full border-[0.5px] border-n0 ">
                  </span>
                </div>
                <div class="relative">
                  <span
                    class="absolute -top-1 -right-2 text-xs rounded-full h-5 min-w-max px-1.5 bg-error text-n0 f-center font-bold">99</span>
                  <i class="las la-bell text-4xl"></i>
                </div>
                <div class="relative">
                  <span
                    class="absolute -top-1 -right-3 text-xs rounded-full h-5 min-w-max px-1.5 bg-error text-n0 f-center font-bold">999</span>
                  <i class="las la-bell text-4xl"></i>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg"> &#x3C;div class=&#x22;flex gap-4 lg:gap-6 flex-wrap&#x22;&#x3E;
                      &#x3C;div class=&#x22;relative&#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute -top-0.5 -right-1.5 text-[10px] rounded-full size-4 bg-primary text-white f-center font-bold&#x22;&#x3E;5&#x3C;/span&#x3E;
                      &#x3C;i class=&#x22;las la-bell text-4xl&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;relative&#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute -top-0.5 -right-1.5 text-[10px] rounded-full size-4 bg-secondary text-white f-center font-bold&#x22;&#x3E;5&#x3C;/span&#x3E;
                      &#x3C;i class=&#x22;las la-bell text-4xl&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;relative size-10 rounded-full bg-n50 &#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute bottom-0 f-center size-4 right-0 text-n0 bg-secondary rounded-full border border-n0 &#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-clock text-xs&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;relative size-10 rounded-full bg-n50 &#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute bottom-0 f-center size-4 right-0 text-n0 bg-primary rounded-full border-[0.5px] border-n0 &#x22;&#x3E; &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;relative&#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute -top-1 -right-2 text-xs rounded-full h-5 min-w-max px-1.5 bg-error text-n0 f-center font-bold&#x22;&#x3E;99&#x3C;/span&#x3E;
                      &#x3C;i class=&#x22;las la-bell text-4xl&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;relative&#x22;&#x3E;
                      &#x3C;span class=&#x22;absolute -top-1 -right-3 text-xs rounded-full h-5 min-w-max px-1.5 bg-error text-n0 f-center font-bold&#x22;&#x3E;999&#x3C;/span&#x3E;
                      &#x3C;i class=&#x22;las la-bell text-4xl&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E; </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Breadcrumb -->
      <div class="white-box">
        <h4 class="mb-4">Breadcrumb</h4>
        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="space-y-4 xl:space-y-6">
                <ul class="flex gap-1 items-center">
                  <li><a href="index.html">Home </a></li>
                  <li>/</li>
                  <li><a href="#">Components </a></li>
                  <li>/</li>
                  <li><span class="text-primary-300 font-medium"> Breadcrumbs </span></li>
                </ul>
                <ul class="flex flex-wrap gap-1 items-center">
                  <li>
                    <a class="flex items-center gap-2" href="index.html"> <i class="las la-home text-xl shrink-0"></i>
                      <span>Home</span></a>
                  </li>
                  <li>/</li>
                  <li>
                    <a class="flex items-center gap-2" href="#"> <i class="las la-layer-group text-xl shrink-0"></i>
                      <span>Components</span></a>
                  </li>
                  <li>/</li>
                  <li>
                    <span class="text-primary-300 flex items-center gap-2 font-medium"> <i
                        class="las la-bell text-xl shrink-0"></i> <span>Breadcrumbs</span></span>
                  </li>
                </ul>

                <ul class="flex flex-wrap gap-2 items-center">
                  <li>
                    <a class="flex items-center gap-2" href="index.html"> <i
                        class="las text-lg xl:text-xl xxl:text-2xl la-home shrink-0"></i> <span>Home</span></a>
                  </li>
                  <li class="text-sm text-n700 ">•</li>
                  <li>
                    <a class="flex items-center gap-2" href="#"> <i
                        class="las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0"></i> <span>Link 1</span></a>
                  </li>
                  <li class="text-sm text-n700 ">•</li>
                  <li>
                    <a class="flex items-center gap-2" href="#"> <i
                        class="las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0"></i> <span>Link 2</span></a>
                  </li>
                  <li class="text-sm text-n700 ">•</li>
                  <li>
                    <a class="flex items-center gap-2" href="#"> <i
                        class="las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0"></i> <span>Link 3</span></a>
                  </li>
                  <li class="text-sm text-n700 ">•</li>
                  <li>
                    <span class="flex items-center gap-2 text-primary-300 font-medium"> <i
                        class="las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0"></i> <span>Link
                        4</span></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg"> &#x3C;div class=&#x22;space-y-4 xl:space-y-6&#x22;&#x3E;
                      &#x3C;ul class=&#x22;flex gap-1 items-center&#x22;&#x3E;
                      &#x3C;li&#x3E;&#x3C;a href=&#x22;index.html&#x22;&#x3E;Home &#x3C;/a&#x3E;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;/&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;&#x3C;a href=&#x22;#&#x22;&#x3E;Components &#x3C;/a&#x3E;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;/&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;&#x3C;span class=&#x22;text-primary-300 font-medium&#x22;&#x3E; Breadcrumbs &#x3C;/span&#x3E;&#x3C;/li&#x3E;
                      &#x3C;/ul&#x3E;
                      &#x3C;ul class=&#x22;flex flex-wrap gap-1 items-center&#x22;&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;index.html&#x22;&#x3E; &#x3C;i class=&#x22;las la-home text-xl shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Home&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li&#x3E;/&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;#&#x22;&#x3E; &#x3C;i class=&#x22;las la-layer-group text-xl shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Components&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li&#x3E;/&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;span class=&#x22;text-primary-300 flex items-center gap-2 font-medium&#x22;&#x3E; &#x3C;i class=&#x22;las la-bell text-xl shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Breadcrumbs&#x3C;/span&#x3E;&#x3C;/span&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;/ul&#x3E;

                      &#x3C;ul class=&#x22;flex flex-wrap gap-2 items-center&#x22;&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;index.html&#x22;&#x3E; &#x3C;i class=&#x22;las text-lg xl:text-xl xxl:text-2xl la-home shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Home&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li class=&#x22;text-sm text-n700 &#x22;&#x3E;&#x2022;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;#&#x22;&#x3E; &#x3C;i class=&#x22;las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Link 1&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li class=&#x22;text-sm text-n700 &#x22;&#x3E;&#x2022;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;#&#x22;&#x3E; &#x3C;i class=&#x22;las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Link 2&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li class=&#x22;text-sm text-n700 &#x22;&#x3E;&#x2022;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;a class=&#x22;flex items-center gap-2&#x22; href=&#x22;#&#x22;&#x3E; &#x3C;i class=&#x22;las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Link 3&#x3C;/span&#x3E;&#x3C;/a&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;li class=&#x22;text-sm text-n700 &#x22;&#x3E;&#x2022;&#x3C;/li&#x3E;
                      &#x3C;li&#x3E;
                        &#x3C;span class=&#x22;flex items-center gap-2 text-primary-300 font-medium&#x22;&#x3E; &#x3C;i class=&#x22;las text-lg xl:text-xl xxl:text-2xl la-layer-group shrink-0&#x22;&#x3E;&#x3C;/i&#x3E; &#x3C;span&#x3E;Link 4&#x3C;/span&#x3E;&#x3C;/span&#x3E;
                      &#x3C;/li&#x3E;
                      &#x3C;/ul&#x3E;
                      &#x3C;/div&#x3E; </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="white-box">
        <h4 class="mb-4">Buttons</h4>
        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex gap-4 flex-wrap">
                <button class="btn-primary">Primary</button>
                <button class="btn-secondary">Secondary</button>
                <button class="btn-warning rounded-md">Rounded lg</button>
                <button class="btn-error rounded-md">Rounded lg</button>
                <button class="btn-outline rounded-md hover:text-n0">Primary</button>
                <button
                  class="btn-outline text-secondary border-secondary rounded-md hover:bg-secondary">Secondary</button>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg"> &#x3C;div class=&#x22;flex gap-4 flex-wrap&#x22;&#x3E;
                      &#x3C;button class=&#x22;btn-primary&#x22;&#x3E;Primary&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;btn-secondary&#x22;&#x3E;Secondary&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;btn-warning rounded-md&#x22;&#x3E;Rounded lg&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;btn-error rounded-md&#x22;&#x3E;Rounded lg&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;btn-outline rounded-md hover:text-n0&#x22;&#x3E;Primary&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;btn-outline text-secondary border-secondary rounded-md hover:bg-secondary&#x22;&#x3E;Secondary&#x3C;/button&#x3E;
                      &#x3C;/div&#x3E;  </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chips -->
      <div class="white-box">
        <h4 class="mb-4">Chips</h4>
        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex flex-wrap gap-4">
                <div class="chip primary">
                  <span class="icon">
                    <i class="las la-layer-group"></i>
                  </span>
                  <span>Primary Deletable</span>
                  <span class="icon cursor-pointer">
                    <i class="las la-times"></i>
                  </span>
                </div>
                <div class="chip primary">
                  <span class="icon">
                    <i class="las la-layer-group"></i>
                  </span>
                  <span>Primary Clickable</span>
                </div>
                <!-- secondary chip -->
                <div class="chip secondary">
                  <span class="icon">
                    <i class="las la-layer-group"></i>
                  </span>
                  <span>Secondary Deletable</span>
                  <span class="icon cursor-pointer">
                    <i class="las la-times"></i>
                  </span>
                </div>
                <div class="chip secondary">
                  <span class="icon">
                    <i class="las la-layer-group"></i>
                  </span>
                  <span>Secondary Clickable</span>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-4 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">  &#x3C;div class=&#x22;flex flex-wrap gap-4&#x22;&#x3E;
                      &#x3C;div class=&#x22;chip primary&#x22;&#x3E;
                      &#x3C;span class=&#x22;icon&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-layer-group&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;span&#x3E;Primary Deletable&#x3C;/span&#x3E;
                      &#x3C;span class=&#x22;icon cursor-pointer&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;chip primary&#x22;&#x3E;
                      &#x3C;span class=&#x22;icon&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-layer-group&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;span&#x3E;Primary Clickable&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;!-- secondary chip --&#x3E;
                      &#x3C;div class=&#x22;chip secondary&#x22;&#x3E;
                      &#x3C;span class=&#x22;icon&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-layer-group&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;span&#x3E;Secondary Deletable&#x3C;/span&#x3E;
                      &#x3C;span class=&#x22;icon cursor-pointer&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-times&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;div class=&#x22;chip secondary&#x22;&#x3E;
                      &#x3C;span class=&#x22;icon&#x22;&#x3E;
                        &#x3C;i class=&#x22;las la-layer-group&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/span&#x3E;
                      &#x3C;span&#x3E;Secondary Clickable&#x3C;/span&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;  </code>
                                      </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Dropdown -->
      <div class="white-box">
        <h4 class="mb-4">Dropdown</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex gap-4">
                <div class="dropdown relative max-w-max">
                  <button
                    class="dropdown-toggle bg-primary text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
                    <span class="mr-1">Dropdown</span>
                    <i class="las la-angle-down text-base"></i>
                  </button>
                  <ul class="dropdown-menu absolute hidden text-n700 pt-1 bg-n0 w-full shadow-xl">
                    <li><span class="dropdown-item cursor-pointer rounded-t py-2 px-4 block whitespace-no-wrap">Option
                        1</span></li>
                    <li><span class="dropdown-item cursor-pointer py-2 px-4 block whitespace-no-wrap">Option 2</span></li>
                    <li><span class="dropdown-item cursor-pointer rounded-b py-2 px-4 block whitespace-no-wrap">Option
                        3</span></li>
                  </ul>
                </div>

                <div class="dropdown relative max-w-max">
                  <button
                    class="dropdown-toggle bg-secondary text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
                    <span class="mr-1">Dropdown</span>
                    <i class="las la-angle-down text-base"></i>
                  </button>
                  <ul class="dropdown-menu absolute hidden text-n700 pt-1 bg-n0 w-full shadow-xl">
                    <li><span class="cursor-pointer dropdown-item rounded-t py-2 px-4 block whitespace-no-wrap">Option
                        1</span></li>
                    <li><span class="cursor-pointer dropdown-item py-2 px-4 block whitespace-no-wrap">Option 2</span></li>
                    <li><span class="cursor-pointer dropdown-item rounded-b py-2 px-4 block whitespace-no-wrap">Option
                        3</span></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">
                      &#x3C;div class=&#x22;flex gap-4&#x22;&#x3E;
                      &#x3C;div class=&#x22;dropdown relative max-w-max&#x22;&#x3E;
                      &#x3C;button class=&#x22;dropdown-toggle bg-primary text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2&#x22;&#x3E;
                        &#x3C;span class=&#x22;mr-1&#x22;&#x3E;Dropdown&#x3C;/span&#x3E;
                        &#x3C;i class=&#x22;las la-angle-down text-base&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/button&#x3E;
                      &#x3C;ul class=&#x22;dropdown-menu absolute hidden text-n700 pt-1 bg-n0 w-full shadow-xl&#x22;&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;dropdown-item cursor-pointer rounded-t py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 1&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;dropdown-item cursor-pointer py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 2&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;dropdown-item cursor-pointer rounded-b py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 3&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                      &#x3C;/ul&#x3E;
                      &#x3C;/div&#x3E;

                      &#x3C;div class=&#x22;dropdown relative max-w-max&#x22;&#x3E;
                      &#x3C;button class=&#x22;dropdown-toggle bg-secondary text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2&#x22;&#x3E;
                        &#x3C;span class=&#x22;mr-1&#x22;&#x3E;Dropdown&#x3C;/span&#x3E;
                        &#x3C;i class=&#x22;las la-angle-down text-base&#x22;&#x3E;&#x3C;/i&#x3E;
                      &#x3C;/button&#x3E;
                      &#x3C;ul class=&#x22;dropdown-menu absolute hidden text-n700 pt-1 bg-n0 w-full shadow-xl&#x22;&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;cursor-pointer dropdown-item rounded-t py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 1&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;cursor-pointer dropdown-item py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 2&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                        &#x3C;li&#x3E;&#x3C;span class=&#x22;cursor-pointer dropdown-item rounded-b py-2 px-4 block whitespace-no-wrap&#x22;&#x3E;Option 3&#x3C;/span&#x3E;&#x3C;/li&#x3E;
                      &#x3C;/ul&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      </code>
                                        </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="white-box">
        <h4 class="mb-4">Modal</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <!-- Modal open btn -->
              <button data-modal-target="modal1"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Open Modal</button>
              <!-- Modal element -->
              <div id="modal1" class="fixed inset-0 items-center justify-center z-99 hidden">
                <div class="f-center h-screen w-screen">
                  <div class="bg-white rounded-lg shadow-xl p-6 m-4 max-w-xl w-full">
                    <h2 class="text-2xl font-bold mb-4">Modal Title</h2>
                    <p class="mb-4">This is the content of the modal. You can put any HTML here.</p>
                    <div class="flex justify-end">
                      <button data-modal-close="modal1"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                            <code class="rounded-lg">
                      &#x3C;!-- Modal open btn --&#x3E;
                      &#x3C;button data-modal-target=&#x22;modal1&#x22; class=&#x22;bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4&#x22;&#x3E;Open Modal&#x3C;/button&#x3E;
                      &#x3C;!-- Modal element --&#x3E;
                      &#x3C;div id=&#x22;modal1&#x22; class=&#x22;fixed inset-0 items-center justify-center z-99 hidden&#x22;&#x3E;
                      &#x3C;div class=&#x22;f-center h-screen w-screen&#x22;&#x3E;
                      &#x3C;div class=&#x22;bg-white rounded-lg shadow-xl p-6 m-4 max-w-xl w-full&#x22;&#x3E;
                        &#x3C;h2 class=&#x22;text-2xl font-bold mb-4&#x22;&#x3E;Modal Title&#x3C;/h2&#x3E;
                        &#x3C;p class=&#x22;mb-4&#x22;&#x3E;This is the content of the modal. You can put any HTML here.&#x3C;/p&#x3E;
                        &#x3C;div class=&#x22;flex justify-end&#x22;&#x3E;
                          &#x3C;button data-modal-close=&#x22;modal1&#x22; class=&#x22;bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded&#x22;&#x3E;Close&#x3C;/button&#x3E;
                        &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                            </code>
                                                </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Offcanvas -->
      <div class="white-box">
        <h4 class="mb-4">Offcanvas</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <button data-offcanvas-target="offcanvas1" class="bg-primary text-white font-bold py-2 px-4 rounded">Open
                Off-Canvas</button>

              <!-- Off-canvas element -->
              <div id="offcanvas1"
                class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
                <div class="p-4">
                  <h2 class="text-lg font-semibold mb-4">Off-Canvas Content</h2>
                  <p>This is the content for the off-canvas.</p>
                  <button data-offcanvas-close="offcanvas1"
                    class="mt-4 bg-error  text-white font-bold py-2 px-4 rounded">Close</button>
                </div>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">
                      &#x3C;button data-offcanvas-target=&#x22;offcanvas1&#x22; class=&#x22;bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded&#x22;&#x3E;Open Off-Canvas&#x3C;/button&#x3E;

                      &#x3C;!-- Off-canvas element --&#x3E;
                      &#x3C;div id=&#x22;offcanvas1&#x22; class=&#x22;fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50&#x22;&#x3E;
                      &#x3C;div class=&#x22;p-4&#x22;&#x3E;
                      &#x3C;h2 class=&#x22;text-lg font-semibold mb-4&#x22;&#x3E;Off-Canvas Content&#x3C;/h2&#x3E;
                      &#x3C;p&#x3E;This is the content for the off-canvas.&#x3C;/p&#x3E;
                      &#x3C;button data-offcanvas-close=&#x22;offcanvas1&#x22; class=&#x22;mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded&#x22;&#x3E;Close&#x3C;/button&#x3E;
                      &#x3C;/div&#x3E;
                      &#x3C;/div&#x3E;
                      </code>
                                        </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Toast Notification -->
      <div class="white-box">
        <h4 class="mb-4">Toast</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex items-center gap-4 flex-wrap">
                <button class="bg-primary text-white font-medium rounded-md py-2 px-4" data-toast="success"
                  data-message="This is success Toast">Success Toast</button>
                <button class="bg-error text-white font-medium rounded-md py-2 px-4" data-toast="error"
                  data-message="This is error Toast">Error Taost</button>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">
                      &#x3C;div class=&#x22;flex items-center gap-4 flex-wrap&#x22;&#x3E;
                      &#x3C;button class=&#x22;bg-primary text-white font-medium rounded-md py-2 px-4&#x22; data-toast=&#x22;success&#x22; data-message=&#x22;This is success Toast&#x22;&#x3E;Success Toast&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;bg-error text-n0 font-medium rounded-md py-2 px-4&#x22; data-toast=&#x22;error&#x22; data-message=&#x22;This is error Toast&#x22;&#x3E;Error Taost&#x3C;/button&#x3E;
                      &#x3C;/div&#x3E;
                      </code>
                                        </pre>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tooltip -->
      <div class="white-box">
        <h4 class="mb-4">Tooltip</h4>

        <div class="tabs">
          <ul class="tab-navigation" role="tablist">
            <li class="mr-1">
              <a href="#" class="tab-link active">Preview</a>
            </li>
            <li class="mr-1">
              <a href="#" class="tab-link">Code</a>
            </li>
          </ul>
          <div class="tab-content mt-4">
            <div class="tab-panel active">
              <div class="flex flex-wrap gap-6">
                <button class="hint--top hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Tooltip on Top">Top</button>
                <button class="hint--bottom hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Tooltip on Bottom">Bottom</button>
                <button class="hint--left hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Tooltip on Left Side">Left</button>
                <button class="hint--right hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Tooltip on Right Side">Right</button>
                <button class="hint--top hint--error hint--rounded bg-error px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Error Tooltip">Error</button>
                <button
                  class="hint--top hint--warning hint--rounded bg-warning px-4 py-2 text-white font-medium rounded-md"
                  aria-label="Warning Tooltip">Warning</button>
              </div>
            </div>
            <div class="tab-panel hidden">
              <div class="code relative">
                <button
                  class="copy-code px-2 py-1 f-center gap-2 border text-sm rounded-lg border-primary absolute top-9 z-2 text-primary right-3"><i
                    class="las la-copy"></i><span class="btn-text">Copy</span></button>
                <pre>
                      <code class="rounded-lg">&#x3C;div class=&#x22;flex flex-wrap gap-6&#x22;&#x3E;
                      &#x3C;button class=&#x22;hint--top hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Tooltip on Top&#x22;&#x3E;Top&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;hint--bottom hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Tooltip on Bottom&#x22;&#x3E;Bottom&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;hint--left hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Tooltip on Left Side&#x22;&#x3E;Left&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;hint--right hint--rounded bg-primary px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Tooltip on Right Side&#x22;&#x3E;Right&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;hint--top hint--error hint--rounded bg-error px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Error Tooltip&#x22;&#x3E;Error&#x3C;/button&#x3E;
                      &#x3C;button class=&#x22;hint--top hint--warning hint--rounded bg-warning px-4 py-2 text-white font-medium rounded-md&#x22; aria-label=&#x22;Warning Tooltip&#x22;&#x3E;Warning&#x3C;/button&#x3E;
                      &#x3C;/div&#x3E;</code>
                                          </pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection