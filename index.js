const images = document.querySelectorAll("img")
const H1 = document.querySelectorAll("H1")
const H2 = document.querySelectorAll("H2")
const H3 = document.querySelectorAll("H3")

let options = {
  
  rootMargin: "-10% 0px",
  threshold: 0.4
}

function handleIntersect(entries){
  console.log(entries);

  entries.forEach(entry => {
    if(entry.isIntersecting){
      entry.target.style.opacity = 1;
    }
  })
}

const observer = new IntersectionObserver(handleIntersect, options)

images.forEach(image => {
  observer.observe(image)
})

H1.forEach(H1 => {
    observer.observe(H1)
})


H2.forEach(H2 => {
    observer.observe(H2)
})

H3.forEach(H3 => {
    observer.observe(H3)
})