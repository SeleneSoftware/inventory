import jwt

payload = {
    "mercure": {
        "publish": ["*"]
    }
}

secret = "nQp2WGR2YxJRHqbwl6N0FX+0NOgcnTR5vavVcQ9+VNk="
token = jwt.encode(payload, secret, algorithm="HS256")
print(token)

