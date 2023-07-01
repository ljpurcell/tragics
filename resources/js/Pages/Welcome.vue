<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="bg-green-800 relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('scoreboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-yellow-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Scoreboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="mx-1 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-yellow-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <!-- <Link -->
                <!--     :href="route('register')" -->
                <!--     class="mx-1 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-yellow-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" -->
                <!--     >Register</Link -->
                <!-- > -->
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="mt-16">
                <div class="text-yellow-500 text-2xl font-semibold">
                    Welcome, cricket tragics...
                </div>
            </div>
        </div>
    </div>
</template>


