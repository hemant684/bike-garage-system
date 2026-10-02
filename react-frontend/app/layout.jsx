import '../src/legacy.css'
import '../src/index.css'

export const metadata = {
  title: {
    default: 'Bike Garage | Service and Repairs',
    template: '%s | Bike Garage',
  },
  description: 'Book trusted bike servicing and repairs with Bike Garage.',
}

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <head>
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        />
      </head>
      <body>{children}</body>
    </html>
  )
}
