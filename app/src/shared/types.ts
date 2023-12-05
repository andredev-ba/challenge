export type BreadcrumbItem = {
  text?: string;
  link?: string;
  icon: string;
}

export type TableColumn = {
  name: string;
  label: string;
  align?: 'left' | 'center' | 'right';
  field: string;
  sortable?: boolean;
  sort?: (a: any, b: any, rowA: any, rowB: any) => number;
  style?: string;
};

export type ProductRow = {
  name: string;
  description: string;
  price: string;
  expirationDate: string;
  categoryId: string;
  imageUrl: string;
};

export type CategoryRow = {
  name: string
};
