export const URLS = {
  Dashboard: {
    name: 'Dashboard',
    title: 'Dasbor',
    href: '/dashboard?timestamp=hari',
  },
  Cashier: {
    name: 'Cashier',
    title: 'Kasir',
    href: '/cashier',
  },
  Stock: {
    name: 'Stock',
    title: 'Manajemen Penyimpanan',
    href: '/stock',
  },
  GoldPawn: {
    name: 'GoldPawn',
    title: 'Gadai Emas',
    href: '/pawn',
  },
  BookKeeping: {
    name: 'BookKeeping',
    title: 'Pembukuan',
    href: '/bookkeeping',
  },
  BookKeepingDetail: {
    name: 'BookKeepingDetail',
    title: 'Detail Pembukuan',
    href: '/bookkeepingDetail',
  },
  GoldCarat: {
    name: 'GoldCarat',
    title: 'Karat Emas',
    href: '/goldCarat',
  },
  Shelf: {
    name: 'Shelf',
    title: 'Rak',
    href: '/shelf',
  },
  Category: {
    name: 'Category',
    title: 'Kategori',
    href: '/category',
  },
  Notification: {
    title: 'Notifikasi',
    href: '/notification'
  },
  Customer: {
    title: 'Pelanggan',
    href: '/customer'
  },
  Employee: {
    title: 'Admin/Karyawan',
    href: '/employee'
  },
  Register: {
    title: 'Register',
    href: '/register'
  },
  TransactionHistory: {
    title: 'Riwayat Transaksi Penjualan',
    href: '/goldTransactionHistory'
  },
  GetCustomerByName: {
    title: 'Mengambil Data Nama Customer',
    href: '/getCustomerByName'
  },
  GetPawnTransactionByFilter: {
    title: 'Mengambil Data Transaksi Gadai',
    href: '/getPawnTransactionByFilter'
  },
  GetStockById: {
    title: 'Mengambil Data Customer',
    href: '/getStockById'
  },
}

export const URLSub = {
  showStock: {
    title: 'Stok Emas',
  },
  editStock: {
    title: 'Edit Stok Emas',
  },
  addStock: {
    title: 'Tambah Stok Emas',
    href: URLS.Stock.href + '/create',
  },
  addGoldCarat: {
    title: 'Tambah Stok Emas',
    href: URLS.Stock.href + '/create',
  },
  showGoldCarat: {
    title: 'Karat Emas',
  },
  editGoldCarat: {
    title: 'Ubah Karat Emas',
  },
  addGoldCarat: {
    title: 'Tambah Karat Emas',
  },
  showShelf: {
    title: 'Rak',
  },
  editShelf: {
    title: 'Ubah Rak',
  },
  addShelf: {
    title: 'Tambah Rak',
  },
  showCategory: {
    title: 'Kategori Emas',
  },
  editCategory: {
    title: 'Ubah Kategori Emas',
  },
  addCategory: {
    title: 'Tambah Kategori Emas',
  },
  addCustomer: {
    title: 'Tambah Pelanggan',
  },
  editCustomer: {
    title: 'Ubah Pelanggan',
  },
}

export const MENUS = [
  {
    ...URLS.Dashboard,
    isAdmin: false,
  },
  {
    ...URLS.TransactionHistory,
    isAdmin: false,
  },
  {
    ...URLS.Cashier,
    isAdmin: false,
  },
  {
    ...URLS.Stock,
    isAdmin: false,
  },
  {
    ...URLS.GoldPawn,
    isAdmin: false,
  },
  {
    ...URLS.BookKeeping,
    isAdmin: true,
  },
  {
    ...URLS.GoldCarat,
    isAdmin: true,
  },
  {
    ...URLS.Shelf,
    isAdmin: true,
  },
  {
    ...URLS.Category,
    isAdmin: true,
  },
  {
    ...URLS.Customer,
    isAdmin: false,
  },
  {
    ...URLS.Employee,
    isAdmin: true,
  },
]

export const GetURLS = (page = '', index = '', now = '') => {
  let final = '';

  final = URLS[page].href;

  if (index) {
    final = final + '/' + index;
  }

  switch (now) {
    case 'edit':
      final += '/edit';
      break;
    case 'add':
      final += '/create';
      break;
    case 'checkout':
      final += '/checkout';
      break;
    case 'PawnMarkAsDone':
      final += '/showPawnTransactionHeaderAsDonePage';
      break;
    default:
      break;
  }
  return final;
}

export const GetTitle = (page = '', now = '') => {
  let final = '';

  final = URLS[page].title;

  switch (now) {
    case 'edit':
      final = 'Ubah ' + final;
      break;
    case 'add':
      final = 'Tambah ' + final;
      break;
    default:
      break;
  }
  return final;
}

export const isGreenOrRedColor = (isAddition) => {
  if (isAddition === 1) {
    return 'text-green-700'
  } else {
    return 'text-red-700'
  }
}

export const IsAdmin = (isAdmin) => {
  if (isAdmin == 1) {
    return true;
  }

  return false;
}

export const GetURLSEditStock = (index) => {
  return URLS.Stock.href + '/' + index + '/edit';
}

export const GetURLSUpdateStock = (index) => {
  return URLS.Stock.href + '/' + index;
}

export const GetURLSDeleteStock = (index) => {
  return URLS.Stock.href + '/' + index;
}

export const GetAddGoldCarat = () => {
  const url = URLS.GoldCarat.href + '/create';
  const title = 'Tambah Karat Emas';

  return {
    url,
    title,
  }
}

export const GetURLSEditGoldCarat = (index) => {
  return URLS.GoldCarat.href + '/' + index + '/edit';
}

export const GetURLSUpdateGoldCarat = (index) => {
  return URLS.GoldCarat.href + '/' + index;
}

export const GetURLSDeleteGoldCarat = (index) => {
  return URLS.GoldCarat.href + '/' + index;
}

export const GetURLSAddShelf = () => {
  return URLS.Shelf.href + '/create';
}

export const GetURLSEditShelf = (index) => {
  return URLS.Shelf.href + '/' + index + '/edit';
}

export const GetURLSUpdateShelf = (index) => {
  return URLS.Shelf.href + '/' + index;
}

export const GetURLSDeleteShelf = (index) => {
  return URLS.Shelf.href + '/' + index;
}

export const GetURLSMarkAsReadNotification = (index) => {
  return '/markAsRead/' + index;
}

export const GetURLSMarkAllUnreadNotificationsAsReadNotification = () => {
  return '/markAllUnreadNotificationsAsRead';
}

export const GetURLSDeleteNotification = (index) => {
  return URLS.Notification.href + '/' + index;
}

export const GetURLSDestroyAllUnreadNotifications = () => {
  return '/destroyAllUnreadNotifications';
}

export const GetURLSDestroyAllReadNotifications = () => {
  return '/destroyAllReadNotifications';
}

export const GetURLSAddCategory = () => {
  return URLS.Category.href + '/create';
}

export const GetURLSEditCategory = (index) => {
  return URLS.Category.href + '/' + index + '/edit';
}

export const GetURLSUpdateCategory = (index) => {
  return URLS.Category.href + '/' + index;
}

export const GetURLSDeleteCategory = (index) => {
  return URLS.Category.href + '/' + index;
}
