<template>
    <app-layout title="Create Blog">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Blog
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <span class="text-red-500">
                        TODO: Show form to create blog
                    </span>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default defineComponent({
    components: {
        AppLayout,
    },
});
</script>
