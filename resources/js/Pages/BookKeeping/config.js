export const CountTotalBookKeeping = (BookKeeping) => {
  const totalQty = BookKeeping.map((item) => {
        return (
          {
            quantity: item.quantity,
            isAddition: item.isAddition,
          }
        )
      }).reduce((prev, cur) => {
        
        if (cur.isAddition) {
          return prev + cur.quantity
        } else {
          return prev - cur.quantity
        }
      }, 0);

  const totalWeight = BookKeeping.map((item) => {
    return (
      {
        totalWeight: item.totalWeight,
        isAddition: item.isAddition,
      }
    )
  }).reduce((prev, cur) => {
    if (cur.isAddition) {
      return prev + cur.totalWeight
    } else {
      return prev - cur.totalWeight
    }
  }, 0);

  const totalPrice = BookKeeping.map((item) => {
    return (
      {
        price: item.totalPrice,
        isAddition: item.isAddition,
      }
    );
  }).reduce((prev, cur) => {
    if (cur.isAddition) {
      return prev + cur.price
    } else {
      return prev - cur.price
    }
  }, 0);

  return {
    totalQty,
    totalWeight,
    totalPrice,
  }
}

export const getBookKeepingDetailsIds = (bookKeepingDetails) => {
  const bookKeepingDetailIds = []
    for (let index = 0; index < bookKeepingDetails.length; index++) {
      const bookKeepingDetail = bookKeepingDetails[index];
      bookKeepingDetailIds.push(bookKeepingDetail.id)
    }
  return bookKeepingDetailIds
}
