'use client'

import { useEffect, useRef } from 'react'

let revealObserver

const observeReveal = (element) => {
  if (!revealObserver) {
    revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible')
            revealObserver.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.12, rootMargin: '0px 0px -36px 0px' },
    )
  }

  revealObserver.observe(element)
}

const Reveal = ({ as: Element = 'div', children, className = '', delay = 0, ...props }) => {
  const elementRef = useRef(null)

  useEffect(() => {
    const element = elementRef.current
    document.documentElement.classList.add('motion-ready')

    if (!element) return undefined

    if (
      !('IntersectionObserver' in window) ||
      window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) {
      element.classList.add('is-visible')
      return undefined
    }

    observeReveal(element)
    return () => revealObserver?.unobserve(element)
  }, [])

  return (
    <Element
      ref={elementRef}
      className={`scroll-reveal ${className}`.trim()}
      style={{ '--reveal-delay': `${delay}ms` }}
      {...props}
    >
      {children}
    </Element>
  )
}

export default Reveal
