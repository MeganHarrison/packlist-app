import { NextRequest, NextResponse } from 'next/server'

export const GET = async () => {
  const params = new URLSearchParams({
    client_id: process.env.KEAP_CLIENT_ID || '',
    redirect_uri: process.env.KEAP_REDIRECT_URI || '',
    response_type: 'code',
    scope: 'full',
  })

  return NextResponse.redirect(
    `${process.env.KEAP_AUTH_URL}?${params.toString()}`,
  )
}
