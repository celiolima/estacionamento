#!/bin/bash

if [ "$NODE_ENV" == "production" ] ; then
  npm run startcd cd
else
  npm run dev
fi