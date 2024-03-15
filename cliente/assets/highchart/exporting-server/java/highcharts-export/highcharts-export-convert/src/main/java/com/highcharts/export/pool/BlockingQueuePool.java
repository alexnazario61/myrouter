package com.highcharts.export.pool;

import java.util.concurrent.BlockingQueue;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.concurrent.TimeUnit;

public class BlockingQueuePool<T> extends AbstractPool<T> {

    private final BlockingQueue<T> linkQueue;

    /**
     * @param factory
     * @param number
     * @throws PoolException
     */
    public BlockingQueuePool(ObjectFactory<T> factory, int number, int maxWait) throws PoolException {
        super(factory, number, maxWait);
        linkQueue = new LinkedBlockingQueue<>(number);
    }

    @Override
    public T borrowObject() throws InterruptedException, PoolException {
        T object = linkQueue.poll(2000, TimeUnit.MILLISECONDS);
        if (object == null) {
            throw new PoolException("Could not borrow object from the pool within the allowed wait time.");
        }
        poolSize.getAndDecrement();

        return object;
    }

    @Override
    public void returnObject(T object, boolean validate) throws InterruptedException {
        if (object == null) {
            return;
        }

        boolean valid = (validate && objectFactory.validate(object)) || !validate;

        if (!valid) {
            destroyObject(object);
        } else {
            objectFactory.passivate(object);
            linkQueue.offer(object, maxWait, TimeUnit.MILLISECONDS);
            poolSize.incrementAndGet();
        }
    }
}
