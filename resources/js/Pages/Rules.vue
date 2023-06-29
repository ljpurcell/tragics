<template>
    <Head title="Rules" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scoreboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="(rule, index) in data" class="border-b border-gray-100 border-1 w-full text-lg py-6 px-8">
                        <div class="w-full flex justify-between">
                           <div class="capitalize font-semibold mb-1">
                                {{ index + 1}}. {{ rule.name }}
                            </div>
                            <div>
                                {{ rule.points }} {{ rule.points == 1 || rule.points == -1 ? 'point' : 'points' }}
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                            {{ rule.description }}
                            </div>
                            <div class="flex justify-around">
                                <button @click="editRule(rule)" class="text-gray-300 hover:bg-black hover:text-white px-2 py-1 rounded-lg text-xs ml-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button @click="deleteRule(rule)" class="text-red-300 hover:bg-red-500 hover:text-white px-2 py-1 rounded-lg text-xs ml-2">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="showModal">
                <div class="p-4">
                    Editing rule...
                    <div class="m-2">
                        <label for="ruleNameEdit" class="m-2">Name</label>
                        <input id="ruleNameEdit" :value="ruleBeingEdited.name" style="width: 90%" class="text-gray-500 mx-8 p-2 rounded-lg focus:outline-none focus:text-black">
                    </div>
                    <div class="m-2">
                        <label for="ruleDescriptionEdit" class="m-2">Description</label>
                        <input id="ruleDescriptionEdit" :value="ruleBeingEdited.description" style="width: 90%" class="text-gray-500 mx-8 p-2 rounded-lg focus:outline-none focus:text-black">
                    </div>
                <button @click="" class="text-lg p-4 rounded-md bg-green-500 hover:bg-green-400 text-white">
                    Confirm
                </button>
                <button @click="showModal = false; ruleBeingEdited = '';" class="text-lg p-4 rounded-md bg-gray-400 hover:bg-gray-500 text-white">
                    Cancel
                </button>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
</script>
<script>
    export default {

        props: {

        },

        data() {
            return {
                data: '',
                ruleBeingEdited: '',
                showModal: false,
            }
        },
        beforeMount() {
            this.getData();
        },

        methods: {

            getData() {
                axios.get('/api/rules/').then(response => {
                    this.data = response.data.data;
                })
            },

            deleteRule(rule) {
                swal.fire({
                    icon: "warning",
                    title: "Are you sure?",
                    text: "Are you sure you want to delete '" + rule.name + "' as a rule?",
                    showConfirmButton: true,
                    showDenyButton: true,
                })
            },

            editRule(rule) {
                this.ruleBeingEdited = rule;
                this.showModal = true;
            },
        }
    }

</script>
