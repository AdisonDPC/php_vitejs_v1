export function setupCounter (element) {

    let iCounter = 0

  const setCounter = (iCount) => {
    iCounter = iCount
    element.innerHTML = `Count is ${ iCounter }`
  }

  element.addEventListener('click', () => setCounter(iCounter + 1))

  setCounter(0)

}
