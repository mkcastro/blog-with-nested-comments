<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <ul>
                        <li v-for="(blog, key) in blogs" :key="key">
                            <Link
                                :href="route('blogs.show', blog.id)"
                                as="button"
                                class="underline text-sm text-gray-600 hover:text-gray-900"
                                >{{ blog.title }}</Link
                            >
                        </li>
                    </ul>
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
});
</script>
