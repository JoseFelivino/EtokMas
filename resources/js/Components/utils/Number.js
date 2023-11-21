export const NumberFormat = (x) => {
  if (!x) {
    return '0'
  }
  return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}

export const WeightFormat = (x) => {
  if (!x) {
    return '0'
  }
  return NumberFormat(x) + ' g';
}

export const PercentFormat = (x) => {
  if (!x) {
    return '0'
  }
  return NumberFormat(x) + ' %';
}

export const RupiahFormat = (x) => {
  if (!x) {
    return '0'
  }
  return 'Rp. ' + NumberFormat(x);
}
