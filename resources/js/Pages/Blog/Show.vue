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
      <!-- TODO: create a component to house reply -->
      <form @submit.prevent="submit">
        <div>
          <jet-label for="body" value="Leave comment on Blog" />
          <jet-input
            id="body"
            type="text"
            class="mt-1 block w-full"
            v-model="form.body"
          />
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default defineComponent({
  components: {
    AppLayout,
    JetInput,
    JetLabel,
  },
  data() {
    return {
      form: this.$inertia.form({
        commentable_id: this.$page.props.blog.id,
        commentable_type: "blog",
        body: "",
      }),
    };
  },
  computed: {
    blog() {
      return this.$page.props.blog;
    },
  },
  methods: {
    submit() {
      this.form.post(this.route("comments.store"), {
        onFinish: () => this.form.reset(),
      });
    },
  },
});
</script>
