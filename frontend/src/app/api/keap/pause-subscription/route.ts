import { NextRequest, NextResponse } from 'next/server'
import axios from 'axios'

interface PauseRequestBody {
  subscriptionId: string
  newNextBillDate: string // YYYY-MM-DD
}

export const POST = async (req: NextRequest) => {
  const { subscriptionId, newNextBillDate }: PauseRequestBody = await req.json()

  // TODO: Fetch and refresh tokens from secure storage (not shown here)
  const accessToken = 'your_valid_access_token'

  try {
    // Keap PATCH subscription endpoint (see: https://developer.infusionsoft.com/docs/rest/#operation/updateSubscriptionUsingPATCH)
    const response = await axios.patch(
      `${process.env.KEAP_API_BASE}/subscriptions/${subscriptionId}`,
      { next_bill_date: newNextBillDate },
      {
        headers: {
          Authorization: `Bearer ${accessToken}`,
          'Content-Type': 'application/json',
        },
      },
    )

    // Optionally: fetch original subscription and confirm credits/conditions remain unchanged

    return NextResponse.json({ success: true, data: response.data })
  } catch (err: any) {
    return NextResponse.json(
      { error: err.message, details: err.response?.data },
      { status: 500 },
    )
  }
}
