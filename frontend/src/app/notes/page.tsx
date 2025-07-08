import { createServerClient } from '@/utils/supabase'
import { cookies } from 'next/headers'

export default async function Page() {
  const cookieStore = cookies()
  const supabase = createServerClient(cookieStore)
  const { data: notes } = await supabase.from('notes').select()

  return <pre>{JSON.stringify(notes, null, 2)}</pre>
}
