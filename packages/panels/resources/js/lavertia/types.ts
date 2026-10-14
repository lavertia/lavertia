export interface ComponentNode {
    type: string;
    key: string;
    props: Record<string, unknown>;
    components: ComponentNode[];
}

export type TableColumn = {
    key: string;
    label: string;
};

export type TableRow = Record<string, string | number | boolean | null>;
