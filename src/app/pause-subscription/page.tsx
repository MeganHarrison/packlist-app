'use client'

import { useState } from 'react'

interface FormData {
  subscriptionId: string
  newNextBillDate: string
}

export default function PauseSubscriptionPage() {
  const [form, setForm] = useState<FormData>({
    subscriptionId: '',
    newNextBillDate: '',
  })
  const [result, setResult] = useState<object | null>(null)
  const [loading, setLoading] = useState(false)

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value })
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    setResult(null)
    try {
      const res = await fetch('/api/keap/pause-subscription', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form),
      })
      const data = await res.json()
      setResult(data)
    } catch (err) {
      setResult({ error: 'Request failed' })
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="mx-auto max-w-md rounded-xl bg-white p-6 shadow">
      <h1 className="mb-4 text-2xl font-bold">Pause Subscription</h1>
      <form onSubmit={handleSubmit} className="flex flex-col gap-4">
        <input
          type="text"
          name="subscriptionId"
          placeholder="Subscription ID"
          value={form.subscriptionId}
          onChange={handleChange}
          required
          className="rounded border p-2"
        />
        <input
          type="date"
          name="newNextBillDate"
          value={form.newNextBillDate}
          onChange={handleChange}
          required
          className="rounded border p-2"
        />
        <button
          type="submit"
          disabled={loading}
          className="rounded bg-blue-600 p-2 text-white transition hover:bg-blue-700"
        >
          {loading ? 'Pausing...' : 'Pause Subscription'}
        </button>
      </form>
      {result && (
        <div className="mt-4 text-sm">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  )
}
