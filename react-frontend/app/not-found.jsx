import Link from 'next/link'

export default function NotFound() {
  return (
    <main className="not-found">
      <p className="eyebrow">404 · Page not found</p>
      <h1>Looks like this road ends here.</h1>
      <p>The page you are looking for may have moved or no longer exists.</p>
      <Link className="btn btn-primary" href="/">
        Back to home
      </Link>
    </main>
  )
}
