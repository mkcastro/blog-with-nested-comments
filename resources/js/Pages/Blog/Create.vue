<template>
  <app-layout title="Create Blog">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Blog
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
          <form @submit.prevent="submit">
            <div>
              <jet-label for="title" value="Title" />
              <jet-input
                id="title"
                type="text"
                class="mt-1 block w-full"
                v-model="form.title"
                required
                autofocus
              />
            </div>

            <div class="mt-4">
              <jet-label for="body" value="Body" />
              <jet-input
                id="body"
                type="text"
                class="mt-1 block w-full"
                v-model="form.body"
                required
              />
            </div>

            <div class="flex items-center justify-end mt-4">
              <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Store Blog
              </jet-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";

export default defineComponent({
  components: {
    AppLayout,
    JetButton,
    JetInput,
    JetLabel,
    Link,
  },

  props: {
    title: String,
    body: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        title: this.title,
        body: this.body,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("blogs.store"));
    },
  },
});
</script>
