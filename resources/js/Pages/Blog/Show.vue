<template>
  <app-layout :title="blog.title">
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 leading-tight"
        v-text="blog.title"
      ></h2>
    </template>

    <div
      class="
        px-6
        py-10
        w-full
        mx-auto
        prose
        dark:prose-invert
        h-fit
        prose-img:mx-auto
      "
    >
      <h1 v-text="blog.title"></h1>

      <p v-text="blog.body"></p>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";

export default defineComponent({
  components: {
    AppLayout,
    Welcome,
  },
  computed: {
    blog() {
      return this.$page.props.blog;
    },
  },
});
</script>
