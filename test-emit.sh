#!/bin/bash
curl -X POST http://127.0.0.1:6001/emit \
  -H "Content-Type: application/json" \
  -d '{"channel":"test","event":"msg","data":{"test":1}}'
