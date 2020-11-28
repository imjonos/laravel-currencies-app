<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

            <div class="mt-8 text-2xl">
                Welcome to Test Application!
            </div>
            <div class="mt-6 text-gray-500">

            </div>
        </div>
        <div class="rounded bg-gray-100 border shadow-inner p-4">
            <div class="grid grid-flow-col md:grid-rows-1 grid-rows-4">
                <div>
                    <label>ID</label>
                    <input v-model="filter.id" class='form-input rounded-md shadow-sm mt-1 mb-3 block'
                           type="number"></input>
                </div>
                <div>
                    <label class="">Date From</label>
                    <input v-model="filter.date_from" class='form-input rounded-md shadow-sm mt-1 mb-3 block'
                           type="date"></input>
                </div>
                <div>
                    <label class="">Date To</label>
                    <input v-model="filter.date_to" class='form-input rounded-md shadow-sm mt-1 mb-3 block'
                           type="date"></input>
                </div>

                <div>
                    <label class="">Base Currency Date</label>
                    <input v-model="filter.date" class='form-input rounded-md shadow-sm mt-1 mb-3 block'
                           type="date"></input>
                </div>

                <div>
                    <button @click="onClickSearch" class='bg-green-100 form-input rounded-md shadow-sm mt-7 '>Search
                    </button>
                </div>
                <div>
                    <button @click="onClearClick" class='bg-red-100 form-input rounded-md shadow-sm mt-7 '>Clear
                    </button>
                </div>
            </div>

        </div>
        <div class="rounded bg-gray-100 border shadow-inner p-4">
            <div class="grid grid-flow-col md:grid-rows-1 grid-rows-4">
                <div>
                    <label>Base Currency ID</label>
                    <input v-model="filter.base_currency_id" class='form-input rounded-md shadow-sm mt-1 mb-3 block'
                           type="number"></input>
                </div>
                <div>
                    <button @click="getData()" class='bg-green-100 form-input rounded-md shadow-sm mt-7 '>Search
                    </button>
                </div>
                <div>
                    <button @click="onClickBaseIdClear" class='bg-red-100 form-input rounded-md shadow-sm mt-7 '>Clear
                    </button>
                </div>
            </div>
            <chart  v-if="isBaseCurrencyData" :chartdata="chartData" :options="chartOptions"/>
        </div>
        <div class="rounded bg-gray-100 border shadow-inner p-4">
            <table class="shadow min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        Value
                    </th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">
                        Created At
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in localData" @click.prevent="onRowClick(item.attributes.num_code)"
                    class="hover:bg-gray-100 cursor-pointer">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-700">{{
                            item.attributes.num_code
                        }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-700">{{
                            item.attributes.name
                        }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-700">{{
                            item.attributes.value
                        }}
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-700">{{
                            item.attributes.created_at
                        }}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#"
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                        Previous
                    </a>
                    <a href="#"
                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ meta.from }}</span>
                            to
                            <span class="font-medium">{{ meta.to }}</span>
                            of
                            <span class="font-medium">{{ meta.total }}</span>
                            results
                        </p>
                        Per page:
                        <select v-model="page.size">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                            <a v-if="isPrev" href="#" @click.prevent="onClickPrev"
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a href="" v-for="pageNumber in pagination" @click.prevent="onClickPage(pageNumber)"
                               :class="{'bg-gray-200': pageNumber===meta.current_page}"
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                {{ pageNumber }}
                            </a>
                            <a v-if="isNext" href="#" @click.prevent="onClickNext"
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <!-- Heroicon name: chevron-right -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<script>

import Label from "@/Jetstream/Label";
import Chart from "./Chart";

export default {
    name: "Currencies",
    components: {Label, Chart},
    data: () => ({
        localData: [],
        page: {
            size: 10,
            number: 1
        },
        filter: {
            id: null,
            date_from: null,
            date_to: null,
            date: null,
            base_currency_id: null
        },
        baseCurrencyData: [],
        pageCount: 2,
        isNext: false,
        isPrev: false,
        pagination: [],
        meta: {},
        chartData: {
            labels: [],
            datasets: [
                {
                    label: '',
                    backgroundColor: '#ccc',
                    data: []
                }
            ]
        },
        chartOptions: {
            responsive: true,
            maintainAspectRatio: false
        }

    }),
    mounted() {
        this.getData();
    },
    computed: {
        isBaseIdSet() {
            return !!this.filter.base_currency_id
        },
        isBaseCurrencyData(){
            return !_.isEmpty(this.baseCurrencyData);
        }
    },
    methods: {
        getData() {
            this.localData = [];
            this.meta = {};
            axios.get('/api/v1/currencies?' + this.getQueryString()).then(response => {
                this.localData = response.data.data;
                this.meta = response.data.meta;
                this.setPagination();
                if (this.isBaseIdSet && (_.isEmpty(this.baseCurrencyData)
                    || (!_.isEmpty(this.baseCurrencyData[0].attributes) && this.baseCurrencyData.[0].attributes.num_code!==Number(this.filter.base_currency_id)))) {
                    this.getBaseCurrencyData();
                }
            }).catch(error => {
                console.log(error)
            });
        },
        getBaseCurrencyData() {
            this.baseCurrencyData = [];
            //Last 30 days
            axios.get('/api/v1/currencies/?page[size]=30&page[number]=1&filter[id]=' + this.filter.base_currency_id).then(response => {
                this.baseCurrencyData = response.data.data;
                this.setChartData();
            }).catch(error => {
                console.log(error)
            });
        },
        onClearClick() {
            this.page.number = 1;
            this.filter.id = null;
            this.filter.date_from = null;
            this.filter.date_to = null;
            this.filter.date = null;

            this.getData();
        },
        onClickSearch(){
            this.page.number = 1;
            this.getData();
        },
        onClickBaseIdClear(){
            this.filter.base_currency_id = null;
            this.baseCurrencyData = [];
            this.getData();
        },
        onRowClick(id) {
            this.filter.id = id;
            this.getData();
        },
        onClickPrev() {
            this.page.number -= 1;
        },
        onClickNext() {
            this.page.number += 1;
        },
        onClickPage(pageNumber) {
            this.page.number = pageNumber;
            return false;
        },
        getQueryString() {
            let result = '';
            _.forEach(this.page, (val, key) => {
                if (!_.isEmpty(result)) result += '&';
                result += 'page[' + key + ']=' + val;
            });

            _.forEach(this.filter, (val, key) => {
                if (val) result += '&filter[' + key + ']=' + val;
            });

            return result;
        },
        setChartData() {
            let labels = [], data = [], min = 0, max = 0, avg = 0, name = '';
            _.forEach(this.baseCurrencyData, item => {
                labels.push(item.attributes.created_at);
                min = item.attributes.min_value;
                max = item.attributes.max_value;
                avg = item.attributes.avg_value;
                name = item.attributes.name;
                data.push(item.attributes.value);
            });

            this.chartData = {
                labels: labels,
                datasets: [{
                    label: name + ' Min: ' + min + ' Max: ' + max + ' Avg: ' + avg,
                    backgroundColor: '#ccc',
                    data: data
                }]
            };
        },
        setPagination() {
            let start = this.meta.current_page - this.pageCount,
                end = this.meta.current_page + this.pageCount,
                total = this.meta.last_page;

            this.isPrev = true;
            this.isNext = true;
            this.pagination = [];

            if (start <= 1) {
                end += Math.abs(this.pageCount - start)
                start = 1;
                this.isPrev = false;
            }

            if (end > total) {
                end = total;
                this.isNext = false;
            }

            for (let i = start; i <= end; i++) {
                this.pagination.push(i);
            }
        }
    },
    watch: {
        page: {
            handler: function (val) {
                this.getData();
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>
