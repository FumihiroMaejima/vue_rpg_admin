import { app } from '@storybook/vue3';
import HelloWorld from "../src/components/HelloWorld.vue";

// app.use(HelloWorld)
app.component('my-component', HelloWorld)
// app.mixin({ /* My mixin */ })
