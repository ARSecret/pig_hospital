FROM node:bullseye as build

ARG VITE_BACKEND_URL
RUN test -n "${VITE_BACKEND_URL}"
ENV VITE_BACKEND_URL=${VITE_BACKEND_URL}

WORKDIR /build
COPY package.json .
COPY package-lock.json .
RUN npm install
COPY . .
RUN npm run build

FROM httpd:latest

WORKDIR /usr/local/apache2/htdocs/
COPY my-httpd.conf /usr/local/apache2/conf/httpd.conf
COPY --from=build /build/dist .
