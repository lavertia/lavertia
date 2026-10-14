<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import type { ComponentNode, TableColumn, TableRow } from './types';

const props = defineProps<{ node: ComponentNode }>();

const text = computed(() => String(props.node.props.content ?? ''));
const columns = computed<TableColumn[]>(() => props.node.components
    .filter((child) => child.type === 'text-column')
    .map((child) => ({
        key: String(child.props.name ?? ''),
        label: String(child.props.label ?? child.props.name ?? ''),
    })));
const rows = computed<TableRow[]>(() =>
    Array.isArray(props.node.props.rows) ? props.node.props.rows as TableRow[] : []
);
const label = computed(() => String(props.node.props.label ?? props.node.props.name ?? ''));
const placeholder = computed(() => String(props.node.props.placeholder ?? ''));
const href = computed(() => String(props.node.props.href ?? ''));
const localValue = ref(String(props.node.props.value ?? ''));

watch(() => props.node.props.value, (value) => {
    localValue.value = String(value ?? '');
});
</script>

<template>
    <div v-if="node.type === 'column' || node.type === 'container'" class="flex flex-col gap-4">
        <ComponentRenderer v-for="child in node.components" :key="child.key" :node="child" />
    </div>

    <div v-else-if="node.type === 'row'" class="flex flex-wrap gap-4">
        <ComponentRenderer v-for="child in node.components" :key="child.key" :node="child" />
    </div>

    <section v-else-if="node.type === 'card'" class="min-w-0 rounded-lg border border-gray-200 p-4 dark:border-gray-700">
        <div class="flex flex-col gap-3">
            <ComponentRenderer v-for="child in node.components" :key="child.key" :node="child" />
        </div>
    </section>

    <p v-else-if="node.type === 'text'" class="text-gray-900 dark:text-gray-100">{{ text }}</p>

    <div v-else-if="node.type === 'table'" class="min-w-0 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
            <thead>
                <tr>
                    <th v-for="column in columns" :key="column.key" scope="col" class="px-3 py-2 text-start font-semibold">
                        {{ column.label }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="(row, index) in rows" :key="index">
                    <td v-for="column in columns" :key="column.key" class="px-3 py-2">{{ row[column.key] ?? '' }}</td>
                </tr>
            </tbody>
        </table>
        <p v-if="rows.length === 0" class="px-3 py-4 text-sm text-gray-500">No records</p>
    </div>

    <div v-else-if="node.type === 'infolist'" class="flex flex-col gap-3">
        <ComponentRenderer v-for="child in node.components" :key="child.key" :node="child" />
    </div>

    <div v-else-if="node.type === 'text-entry'" class="flex flex-col gap-1">
        <span class="text-xs text-gray-500">{{ label }}</span>
        <span class="text-sm">{{ node.props.value ?? '—' }}</span>
    </div>

    <div v-else-if="node.type === 'text-input'" class="flex flex-col gap-1">
        <label :for="node.key" class="text-sm font-medium">{{ label }}</label>
        <input :id="node.key" v-model="localValue" type="text" :name="String(node.props.name ?? '')"
               :placeholder="placeholder" class="rounded-md border border-gray-300 px-3 py-2 dark:border-gray-700" />
    </div>

    <Link v-else-if="node.type === 'action' && href.startsWith('/')" :href="href"
          class="inline-flex w-fit rounded-md bg-gray-900 px-3 py-2 text-sm text-white dark:bg-gray-100 dark:text-gray-900">
        {{ label }}
    </Link>

    <a v-else-if="node.type === 'action' && href.startsWith('https://')" :href="href" rel="noopener noreferrer"
       class="inline-flex w-fit rounded-md bg-gray-900 px-3 py-2 text-sm text-white dark:bg-gray-100 dark:text-gray-900">
        {{ label }}
    </a>

    <span v-else-if="node.type === 'action'" class="text-sm">{{ label }}</span>

    <p v-else class="text-sm text-red-700" role="alert">Unsupported component: {{ node.type }}</p>
</template>
