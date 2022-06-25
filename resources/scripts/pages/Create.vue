<template>
    <div>
        <div class="mt-8 max-w-2xl  mx-auto">
            <div class="grid grid-cols-none">
                <div class="mt-6 flex items-center">
                    <router-link class="py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-3 font-normal" to="/">
                        <svg class="w-6 h-6 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </router-link>
                </div>
                <form class="bg-white shadow-md rounded content-center justify-center px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :class="{ 'mb-3 border-red-500': hasError('name') }" id="name" v-model="subscriber_data.name" type="text" placeholder="Name">
                        <p class="text-red-500 text-xs italic" v-if="hasError('name')">{{getError('name')}}</p>

                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :class="{ 'mb-3 border-red-500': hasError('email') }" id="email" type="email" v-model="subscriber_data.email" placeholder="Email">
                        <p class="text-red-500 text-xs italic" v-if="hasError('email')">{{getError('email')}}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Status
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight capitalize focus:outline-none focus:shadow-outline" :class="{ 'mb-3 border-red-500': hasError('status') }" v-model="subscriber_data.status">
                            <option v-for="(status, key) in statuses" :key="key" :value="status">{{status}}</option>
                        </select>
                        <p class="text-red-500 text-xs italic" v-if="hasError('status')">{{getError('status')}}</p>
                    </div>
                    <div class="mb-6" v-for="(field, key) in existing_fields">
                        <div v-if="['string', 'number', 'date'].includes(field.type)">
                            <label class="block text-gray-700 text-sm font-bold mb-2" :for="key">
                                {{ field.title }}
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="key" v-model="field.value" :type="getType(field.type)" :placeholder="field.title">
                        </div>


                        <div v-else class="form-check">
                            <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" v-model="field.value" type="checkbox" :id="key">
                            <label class="form-check-label inline-block text-gray-800" :for="key">
                                {{field.title}}
                            </label>
                        </div>
                    </div>
                    <hr />
                    <div class="mb-6" v-for="(new_field, key) in new_fields">

                        <label class="block text-gray-700 text-sm font-bold mb-2 mt-2" :for="key">
                            New field {{ key + 1 }}
                        </label>
                        <select v-model="new_fields[key].type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight capitalize focus:outline-none focus:shadow-outline">
                            <option v-for="(type, key) in field_types" :key="key" :value="type">{{type}}</option>
                        </select>

                        <div class="flex flex-wrap mt-6 mb-6">
                            <div class="md:w-1/2">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" :for="key">
                                        Title
                                    </label>
                                    <input class="shadow appearance-none border rounded w-5/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="new_field.title" :id="key" placeholder="Title">
                                </div>
                            </div>
                            <div class="md:w-1/2">
                                <div v-if="['string', 'number', 'date'].includes(new_field.type)">

                                    <label class="block text-gray-700 text-sm font-bold mb-2" :for="key">
                                        Value
                                    </label>
                                    <input class="shadow appearance-none border rounded w-5/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="new_field.value" :id="key" :type="getType(new_field.type)" :placeholder="new_field.title">
                                </div>

                                <div v-else class="form-check mt-6">
                                    <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" v-model="new_field.value" type="checkbox" value="" :id="key">
                                    <label class="form-check-label inline-block text-gray-800" :for="key">
                                        Value
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <button @click.prevent="handleSubmit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Save
                        </button>
                        <button @click.prevent="addCustomField" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                            Add fields
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import handleError from "@/scripts/mixins/handleError";

const NEW_FIELD_STATE = {
    title: '',
    type: 'string',
    value: '',
}

export default {
    name: "App",
    mixins: [handleError],
    data() {
        return {
            new_fields: [],
            existing_fields: [],
            subscriber_data: {
                name: '',
                email: '',
                status: '',
            }
        }
    },
    async created() {
        await this.loadSubscriberStatus()

        if (this.$route.params.id) {
            await this.loadSubscriber(this.$route.params.id)
            this.subscriber_data = JSON.parse( JSON.stringify( this.subscriber ) )
        }

        await this.loadFields({
            subscriber_id: this.$route.params.id
        })

        //we can use mapMutation as well

        //Need better way to do break multi-level binding
        this.existing_fields = JSON.parse( JSON.stringify( this.fields ) )

    },
    methods: {
        ...mapActions('fields', [
            'loadFields'
        ]),
        ...mapActions('subscribers', [
            'loadSubscriberStatus',
            'storeSubscriber',
            'loadSubscriber'
        ]),
        getType(type) {

            if (type === 'string') {
                return 'text';
            }

            if (type === 'boolean') {
                return 'checkbox';
            }

            return type
        },
        addCustomField() {

            this.new_fields.push({...  NEW_FIELD_STATE})
        },
        async handleSubmit() {

            const subscriber_data = {...this.subscriber_data, fields: [...this.existing_fields, ...this.new_fields]}

            const {data} = await this.storeSubscriber(subscriber_data).catch(err => {
                this.errors = err.response.data.errors;
            });

            if (data.status === true) {
                this.$router.push('/')
            }
        }
    },
    computed: {
        ...mapGetters('fields', [
            'fields',
            'field_types',
        ]),
        ...mapGetters('subscribers', [
            'statuses',
            'subscriber'
        ]),
    }
}
</script>

<style scoped>

</style>
