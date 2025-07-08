import { NextRequest, NextResponse } from 'next/server'
import axios from 'axios'
import qs from 'qs'

export const GET = async (req: NextRequest) => {
  const code = req.nextUrl.searchParams.get('code')
  if (!code)
    return NextResponse.json({ error: 'Missing code' }, { status: 400 })

  try {
    const response = await axios.post(
      process.env.KEAP_TOKEN_URL!,
      qs.stringify({
        grant_type: 'authorization_code',
        code,
        redirect_uri: process.env.KEAP_REDIRECT_URI,
        client_id: process.env.KEAP_CLIENT_ID,
        client_secret: process.env.KEAP_CLIENT_SECRET,
      }),
      { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } },
    )

    // Store access/refresh tokens securely (e.g., DB or encrypted session)
    // For demo, we just return it (DO NOT DO THIS IN PROD)
    return NextResponse.json(response.data)
  } catch (err: any) {
    return NextResponse.json(
      { error: err.message, details: err.response?.data },
      { status: 500 },
    )
  }
}
