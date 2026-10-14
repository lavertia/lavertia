<script setup lang="ts">
import ComponentRenderer from '../../lavertia/ComponentRenderer.vue';
import type { ComponentNode } from '../../lavertia/types';

defineProps<{ lavertia: { tree: ComponentNode } }>();
</script>

<template>
    <main class="mx-auto flex w-full max-w-7xl flex-col gap-5 px-4 py-6">
        <ComponentRenderer :node="lavertia.tree" />
    </main>
</template>
