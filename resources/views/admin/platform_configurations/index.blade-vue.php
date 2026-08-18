<x-admin-layout title="">

    <div v-cloak id="platformconfigurations">


        <h1>Platform Configurations</h1>

        <br />
        <br />

        <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.select v-model="filters.company" :options="$companies" empty="-" label="Company" @change="fetchData()" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input v-model="filters.platform" type="text" label="Platform" @keyup="fetchData()" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input v-model="filters.order_type" type="text" label="Order Type" @keyup="fetchData()" />
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button @click="fetchData()">Filter</x-form.button>
                &nbsp;
                <x-form.button @click="resetData()">Reset</x-form.button>
            </div>
        </div>

        <br />
        <br />

        <div v-if="platformConfigurations.data">
            <table class="table table-sm table-bordered w-auto">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Platform</th>
                        <th>Order Type</th>
                        <th>Submission Type</th>
                        <th>Wait Days</th>
                        <th>Sequence</th>
                        <th>Active</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="platformConfiguration in platformConfigurations.data" :key="platformConfiguration.id">
                        <td>@{{ platformConfiguration.company }}</td>
                        <td>@{{ platformConfiguration.platform }}</td>
                        <td>@{{ platformConfiguration.order_type }}</td>
                        <td>@{{ platformConfiguration.submission_type }}</td>
                        <td>@{{ platformConfiguration.wait_days }}</td>
                        <td>@{{ platformConfiguration.sequence }}</td>
                        <td>@{{ platformConfiguration.active ? 'Yes' : 'No' }}</td>
                        <td>@{{ formatDate(platformConfiguration.created_at) }}</td>
                        <td>@{{ formatDate(platformConfiguration.updated_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button @click="changePage(platformConfigurations.prev_page_url)" :disabled="!platformConfigurations.prev_page_url">Prev</button>
        <button @click="changePage(platformConfigurations.next_page_url)" :disabled="!platformConfigurations.next_page_url">Next</button>

    </div>


    <script type="module">
        const {
            createApp,
            ref,
        } = Vue

        createApp({
            setup() {
                const platformConfigurations = ref({
                    data: []
                })
                const filters = ref({
                    company: '',
                    platform: '',
                    order_type: ''
                })
                const baseUrl = '/api/platform-configurations';

                const fetchData = async (url = null) => {
                    url = url || baseUrl
                    const params = new URLSearchParams(filters.value).toString()
                    const fullUrl = url + (url.includes('?') ? '&' : '?') + params
                    console.log('Fetching data from:', fullUrl);
                    platformConfigurations.value = { data: [] } // Reset data before fetching
                    const res = await fetch(fullUrl)
                    platformConfigurations.value = await res.json()
                    // console.log(platformConfigurations.value);
                }

                const resetData = () => {
                    filters.value = {
                        company: '',
                        platform: '',
                        order_type: ''
                    }
                    fetchData()
                }

                const changePage = (url) => {
                    if (url) fetchData(url)
                }

                const formatDate = (dateStr) => {
                    return new Date(dateStr).toLocaleDateString(undefined, {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    })
                }

                fetchData()

                return {
                    platformConfigurations,
                    filters,
                    fetchData,
                    resetData,
                    changePage,
                    formatDate
                }
            }
        }).mount('#platformconfigurations')
    </script>

    <br />
    <br />

    <a href="{{ route('admin.platform-configurations.create') }}" class="btn btn-sm btn-secondary">Add</a>

    <br />
    <br />

</x-admin-layout>