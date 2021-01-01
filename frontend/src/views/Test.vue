<template>
  <div class="container mx-auto">
    <div class="bg-gray-500 my-1 sm:mx-1">
      test
      <!-- <HelloWorld msg="Welcome to Your Vue.js + TypeScript App" /> -->
    </div>
    <div class="my-2">
      <button class="border-2 rounded border-purple-500 hover:border-gray-500">
        Button
      </button>
    </div>
    <h1 class="italic my-2">grid-cols</h1>
    <div class="grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4">
      <div class="bg-gray-500 rounded">grid-cols-3 1</div>
      <div class="bg-gray-500 rounded">grid-cols-3 2</div>
      <div class="bg-gray-500 rounded">grid-cols-3 3</div>
      <div class="bg-gray-500 rounded">grid-cols-3 4</div>
      <div class="bg-gray-500 rounded">grid-cols-3 5</div>
      <div class="bg-gray-500 rounded">grid-cols-3 6</div>
      <div class="bg-gray-500 rounded">grid-cols-3 7</div>
      <div class="bg-gray-500 rounded">grid-cols-3 8</div>
      <div class="bg-gray-500 rounded">grid-cols-3 9</div>
    </div>

    <h1 class="italic my-2">grid-cols flex</h1>

    <div class="grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4">
      <div class="flex">
        <div class="bg-gray-500 rounded">1</div>
        <div class="bg-gray-500 rounded">2</div>
        <div class="bg-gray-500 rounded">3</div>
      </div>

      <div class="flex justify-center">
        <div class="bg-gray-500 rounded">1</div>
        <div class="bg-gray-500 rounded">2</div>
        <div class="bg-gray-500 rounded">3</div>
      </div>

      <div class="flex justify-end">
        <div class="bg-gray-500 rounded">1</div>
        <div class="bg-gray-500 rounded">2</div>
        <div class="bg-gray-500 rounded">3</div>
      </div>
      <!-- <div class="bg-gray-500 rounded">1</div> -->
      <div class="bg-gray-500 rounded">2</div>
      <div class="bg-green-500 rounded">3</div>
      <div class="bg-yellow-500 rounded">4</div>
      <div class="bg-gray-500 rounded">5</div>
      <div class="bg-pink-500 rounded">6</div>
      <div class="bg-gray-500 rounded">7</div>
      <div class="bg-blue-500 rounded">8</div>
      <div class="bg-gray-500 rounded">9</div>
    </div>

    <h1 class="italic my-2">grid-rows</h1>
    <div class="my-2 grid md:grid-rows-3 sm:grid-rows-1 grid-flow-col gap-4">
      <div class="bg-gray-500 rounded">grid-flow-col1</div>
      <div class="bg-gray-500 rounded">grid-flow-col2</div>
      <div class="bg-green-500 rounded">grid-flow-col3</div>
      <div class="bg-yellow-500 rounded">grid-flow-col4</div>
      <div class="bg-gray-500 rounded">grid-flow-col5</div>
      <div class="bg-pink-500 rounded">grid-flow-col6</div>
      <div class="bg-gray-500 rounded">grid-flow-col7</div>
      <div class="bg-blue-500 rounded">grid-flow-col8</div>
      <div class="bg-gray-500 rounded">grid-flow-col9</div>
    </div>

    <h1 class="italic my-2">grid-flow-col button</h1>
    <div class="grid grid-flow-col rounded bg-gray-200 my-1 mx-1">
      <button
        class="bg-red-500 hover:bg-red-600 border-yellow-900 text-white text-sm py-2 px-4 rounded"
      >
        testボタン
      </button>
    </div>

    <h1 class="italic my-2">grid-cols bg-clip-border</h1>
    <div class="grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4">
      <div
        class="bg-clip-border p-4 border-4 border-dashed border-purple-800 bg-purple-500"
      ></div>
      <div
        class="bg-clip-padding p-4 border-4 border-dashed border-purple-800 bg-purple-500"
      ></div>
      <div
        class="bg-clip-content p-4 border-4 border-dashed border-purple-800 bg-purple-500"
      ></div>
    </div>

    <h1 class="italic my-2">buttons</h1>
    <div class="grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4">
      <button class="rounded bg-purple-400 ring-4 ring-indigo-300">
        Button
      </button>
      <button class="rounded bg-purple-300 ring-yellow-500 ring-opacity-50">
        Button
      </button>
      <button
        class="rounded transition duration-500 ease-in-out bg-blue-600 hover:bg-red-600 transform hover:-translate-y-1 hover:scale-110 text-white"
      >
        Hover me
      </button>
      <button
        class="rounded bg-blue-600 hover:bg-red-600 transform hover:scale-110 motion-reduce:transform-none text-white"
      >
        Hover me
      </button>
      <button
        class="py-2 px-4 font-semibold rounded-lg shadow-md text-white bg-green-500 hover:bg-green-700"
      >
        Click me
      </button>
    </div>

    <h1 class="italic my-2">input</h1>
    <div
      class="grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4 bg-purple-100 py-2 px-2"
    >
      <form>
        <input
          class="rounded border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
        />
        <button
          class="ml-2 py-1 px-2 rounded bg-purple-600 hover:bg-purple-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 text-white"
        >
          Sign up
        </button>
      </form>
      <form>
        <input
          class="rounded shadow-inner focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
        />
        <button
          class="ml-2 py-1 px-2 rounded bg-purple-600 hover:bg-purple-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 text-white"
        >
          Sign up
        </button>
      </form>
      <form>
        <input
          class="rounded shadow-inner placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
          placeholder="test-name@example.com"
        />
        <button
          class="ml-2 py-1 px-2 rounded bg-purple-600 hover:bg-purple-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 text-white"
        >
          Sign up
        </button>
      </form>
    </div>

    <h1 class="italic my-2">card</h1>
    <div class="grid rounded grid-flow-col gap-4 bg-purple-100 py-2 px-2">
      <div
        class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl"
      >
        <div class="md:flex">
          <div class="md:flex-shrink-0">
            <img
              class="h-48 w-full object-cover md:w-48"
              src="/img/store.jpg"
              alt="Man looking at item at a store"
            />
          </div>
          <div class="p-8">
            <div
              class="uppercase tracking-wide text-sm text-indigo-500 font-semibold"
            >
              Case study
            </div>
            <a
              href="#"
              class="block mt-1 text-lg leading-tight font-medium text-black hover:underline"
              >Finding customers for your new business</a
            >
            <p class="mt-2 text-gray-500">
              Getting a new business off the ground is a lot of hard work. Here
              are five ideas you can use to find your first customers.
            </p>
          </div>
        </div>
      </div>
    </div>

    <h1 class="italic my-2">flex space-x</h1>
    <div class="grid rounded grid-flow-col gap-4 bg-purple-100 py-2 px-2">
      <div class="flex space-x-4 ...">
        <div class="flex-1 rounded bg-gray-400">flex-1 1</div>
        <div class="flex-1 rounded bg-gray-400">flex-1 2</div>
        <div class="flex-1 rounded bg-gray-400">flex-1 3</div>
      </div>
    </div>

    <h1 class="italic my-2">divide</h1>
    <div class="grid rounded grid-flow-col gap-4 bg-purple-100 py-2 px-2">
      <div class="divide-y-4 divide-yellow-600 divide-dashed">
        <div>1</div>
        <div>2</div>
        <div>3</div>
      </div>
    </div>

    <h1 class="italic my-2">component grid-cols test</h1>
    <grid-cols>
      <div class="bg-gray-500 rounded">grid-cols-3 1</div>
      <div class="bg-gray-500 rounded">grid-cols-3 2</div>
      <div class="bg-gray-500 rounded">grid-cols-3 3</div>
      <div class="bg-gray-500 rounded">grid-cols-3 4</div>
      <div class="bg-gray-500 rounded">grid-cols-3 5</div>
      <div class="bg-gray-500 rounded">grid-cols-3 6</div>
      <div class="bg-gray-500 rounded">grid-cols-3 7</div>
      <div class="bg-gray-500 rounded">grid-cols-3 8</div>
      <div class="bg-gray-500 rounded">grid-cols-3 9</div>
    </grid-cols>

    <h1 class="italic my-2">component grid-rows test</h1>
    <grid-rows>
      <div class="bg-gray-500 rounded">grid-rows1</div>
      <div class="bg-gray-500 rounded">grid-rows2</div>
      <div class="bg-green-500 rounded">grid-rows3</div>
      <div class="bg-yellow-500 rounded">grid-rows4</div>
      <div class="bg-gray-500 rounded">grid-rows5</div>
      <div class="bg-pink-500 rounded">grid-rows6</div>
      <div class="bg-gray-500 rounded">grid-rows7</div>
      <div class="bg-blue-500 rounded">grid-rows8</div>
      <div class="bg-gray-500 rounded">grid-rows9</div>
    </grid-rows>

    <h1 class="italic my-2">component button test</h1>
    <grid-cols>
      <app-button>
        test
      </app-button>
      <chip />
    </grid-cols>

    <h1 class="italic my-2">component input test</h1>
    <grid-cols option="bg-purple-100 py-2 px-2">
      <app-input
        placeholder="test@example.com"
        @app-input="catchAppInputEvent"
      />
      <app-input type="checkbox" @app-input="catchAppInputEvent" />
      <app-input type="radio" @app-input="catchAppInputEvent" />
      <app-input type="date" @app-input="catchAppInputEvent" />
      <app-input type="file" @app-input="catchAppInputEvent" />
      <app-input type="button" @app-input="catchAppInputEvent" />
      <app-input type="reset" @app-input="catchAppInputEvent" />
      <app-input type="password" @app-input="catchAppInputEvent" />
    </grid-cols>

    <h1 class="italic my-2">component card test</h1>
    <grid-rows mdRows="1" option="bg-purple-100 py-2 px-2">
      <card />
    </grid-rows>

    <div class="mt-10 grid rounded md:grid-cols-3 sm:grid-cols-1 gap-4"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import AppButton from '@/components/parts/AppButton.vue'
import AppInput from '@/components/parts/AppInput.vue'
import Card from '@/components/parts/Card.vue'
import Chip from '@/components/parts/Chip.vue'
import GridCols from '@/components/parts/GridCols.vue'
import GridRows from '@/components/parts/GridRows.vue'
// import HelloWorld from '@/components/HelloWorld.vue' // @ is an alias to /src

export default defineComponent({
  name: 'Test',
  components: {
    AppButton,
    AppInput,
    Card,
    Chip,
    GridCols,
    GridRows
  },
  setup() {
    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }
    return {
      catchAppInputEvent
    }
  }
})
</script>
