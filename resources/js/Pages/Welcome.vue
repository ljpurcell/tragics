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
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center" style="background: linear-gradient(45deg, green, yellow, white, red)"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('scoreboard')"
                class="font-semibold text-white hover:text-black">Scoreboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="mx-1 font-semibold text-white hover:text-black hover:text-black"
                    >Log in</Link
                >

                <!-- <Link -->
                <!--     :href="route('register')" -->
                <!--     class="mx-1 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" -->
                <!--     >Register</Link -->
                <!-- > -->
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex mt-16">
                <img src="/ashes.png" class="w-36">
            </div>
        </div>
    </div>
</template>


