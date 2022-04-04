<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blogs</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="flex flex-col gap-4 items-center justify-center mb-8"
          v-for="(blog, key) in blogs"
          :key="key"
        >
          <Link
            :href="route('blogs.show', { blog: blog.id })"
            class="
              w-1/2
              bg-white
              border-2 border-b-4 border-gray-200
              rounded-xl
              hover:bg-gray-50
            "
          >
            <!-- Badge -->

            <div class="grid grid-cols-6 p-5 gap-y-2">
              <!-- Profile Picture -->
              <div>
                <!-- ! this can potentially break -->
                <!-- TODO: add profile picture of author -->
                <img
                  :src="`https://picsum.photos/seed/${blog.id}/200/200`"
                  class="max-w-16 max-h-16 rounded-full"
                />
              </div>

              <!-- Title -->
              <div class="col-span-5 md:col-span-4 ml-4">
                <p class="text-gray-600 font-bold" v-text="blog.title"></p>

                <p
                  class="text-gray-400"
                  v-text="isoToDate(blog.created_at)"
                ></p>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  computed: {
    blogs() {
      return this.$page.props.blogs;
    },
  },

  methods: {
    // TODO: consider refactoring this to a helper
    isoToDate(iso) {
      // format iso to Fri, Mar 11 8:00 PM
      return new Date(iso).toLocaleString("en-US", {
        weekday: "short",
        month: "short",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
      });
    },
  },
});
</script>
